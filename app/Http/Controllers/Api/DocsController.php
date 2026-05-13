<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route as LaravelRoute;
use Illuminate\Support\Arr;

class DocsController extends Controller
{
    public function ui(): \Illuminate\View\View
    {
        return view('docs.api');
    }

    public function openapi(Request $request): JsonResponse
    {
        $serverUrl = url('/api');
        $routes = app('router')->getRoutes();

        $paths = [];

        /** @var LaravelRoute $route */
        foreach ($routes as $route) {
            $uri = $route->uri(); // e.g. "api/post/{slug}"

            if (!str_starts_with($uri, 'api')) {
                continue;
            }

            // Exclude docs endpoints to avoid self-references.
            if ($uri === 'api/openapi') {
                continue;
            }

            $path = $this->toOpenApiPath($uri);
            if ($path === null) {
                continue;
            }

            $methods = array_values(array_diff($route->methods(), ['HEAD']));
            if ($methods === []) {
                continue;
            }

            $parameters = $this->pathParameters($path);

            foreach ($methods as $httpMethod) {
                $method = strtolower($httpMethod);
                $actionName = $route->getActionName();

                $paths[$path][$method] = array_filter([
                    'tags' => [$this->tagFromPath($path)],
                    'summary' => $this->summaryFromAction($actionName, $httpMethod, $path),
                    'operationId' => $this->operationId($httpMethod, $path),
                    'parameters' => $parameters !== [] ? $parameters : null,
                    'responses' => [
                        '200' => ['description' => 'OK'],
                        '404' => ['description' => 'Not Found'],
                    ],
                ], fn ($v) => $v !== null);
            }
        }

        ksort($paths);
        foreach ($paths as $path => $methods) {
            ksort($methods);
            $paths[$path] = $methods;
        }

        $spec = [
            'openapi' => '3.0.3',
            'info' => [
                'title' => config('app.name', 'API Documentation'),
                'version' => '1.0.0',
            ],
            'servers' => [
                ['url' => $serverUrl],
            ],
            'paths' => $paths,
        ];

        return response()->json($spec);
    }

    private function toOpenApiPath(string $uri): ?string
    {
        // Normalize to paths relative to /api server.
        // "api/post/{slug}" => "/post/{slug}"
        // "api" => "/"
        $normalized = ltrim($uri, '/');

        if ($normalized === 'api') {
            return '/';
        }

        if (str_starts_with($normalized, 'api/')) {
            $rest = substr($normalized, 4);
            $rest = $rest === false ? '' : $rest;
            return '/' . ltrim($rest, '/');
        }

        return null;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function pathParameters(string $path): array
    {
        preg_match_all('/\\{([^}]+)\\}/', $path, $matches);
        $names = Arr::get($matches, 1, []);

        $parameters = [];
        foreach ($names as $name) {
            $parameters[] = [
                'name' => $name,
                'in' => 'path',
                'required' => true,
                'schema' => ['type' => 'string'],
            ];
        }

        return $parameters;
    }

    private function tagFromPath(string $path): string
    {
        $segment = trim($path, '/');
        if ($segment === '') {
            return 'root';
        }

        return explode('/', $segment, 2)[0];
    }

    private function summaryFromAction(string $actionName, string $httpMethod, string $path): string
    {
        if ($actionName === 'Closure') {
            return strtoupper($httpMethod) . ' ' . $path;
        }

        $short = $actionName;
        if (str_contains($short, '\\')) {
            $short = class_basename($short);
        }

        return strtoupper($httpMethod) . ' ' . $path . ' (' . $short . ')';
    }

    private function operationId(string $httpMethod, string $path): string
    {
        $id = strtolower($httpMethod) . '_' . trim($path, '/');
        $id = str_replace(['/', '{', '}', '-', '.'], '_', $id);
        $id = preg_replace('/_+/', '_', $id) ?? $id;

        return $id === '' ? strtolower($httpMethod) . '_root' : $id;
    }
}

