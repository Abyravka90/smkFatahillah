<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route as LaravelRoute;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class DocsController extends Controller
{
    private const SCHEMAS = [
        'Division' => [
            'type' => 'object',
            'properties' => [
                'id' => ['type' => 'integer'],
                'name' => ['type' => 'string'],
                'content' => ['type' => 'string'],
                'image' => ['type' => 'string', 'nullable' => true, 'description' => 'URL thumbnail konten'],
                'profile_photo' => ['type' => 'string', 'nullable' => true, 'description' => 'URL foto profil bidang'],
                'created_at' => ['type' => 'string', 'format' => 'date-time'],
                'updated_at' => ['type' => 'string', 'format' => 'date-time'],
                'documents' => [
                    'type' => 'array',
                    'description' => 'Daftar dokumen bidang',
                    'items' => ['$ref' => '#/components/schemas/DivisionDocument'],
                ],
            ],
        ],
        'DivisionDocument' => [
            'type' => 'object',
            'properties' => [
                'id' => ['type' => 'integer'],
                'documentable_type' => ['type' => 'string'],
                'documentable_id' => ['type' => 'integer'],
                'folder' => ['type' => 'string'],
                'filename' => ['type' => 'string', 'description' => 'Nama file di storage'],
                'original_name' => ['type' => 'string', 'description' => 'Nama file asli saat diupload'],
                'mime_type' => ['type' => 'string', 'nullable' => true],
                'size' => ['type' => 'integer', 'description' => 'Ukuran file dalam bytes'],
                'file' => ['type' => 'string', 'description' => 'URL download dokumen'],
                'created_at' => ['type' => 'string', 'format' => 'date-time'],
                'updated_at' => ['type' => 'string', 'format' => 'date-time'],
            ],
        ],
        'DivisionResponse' => [
            'type' => 'object',
            'properties' => [
                'response' => [
                    'type' => 'object',
                    'properties' => [
                        'status' => ['type' => 'integer', 'example' => 200],
                        'message' => ['type' => 'string'],
                    ],
                ],
                'data' => ['$ref' => '#/components/schemas/Division'],
            ],
        ],
        'Photo' => [
            'type' => 'object',
            'properties' => [
                'id' => ['type' => 'integer'],
                'image' => ['type' => 'string'],
                'caption' => ['type' => 'string', 'nullable' => true],
                'created_at' => ['type' => 'string', 'format' => 'date-time'],
                'updated_at' => ['type' => 'string', 'format' => 'date-time'],
            ],
        ],
        'Profile' => [
            'type' => 'object',
            'properties' => [
                'id' => ['type' => 'integer'],
                'name' => ['type' => 'string'],
                'content' => ['type' => 'string'],
                'image' => ['type' => 'string', 'nullable' => true],
                'izin_operasional' => ['type' => 'string', 'nullable' => true],
                'izin_pendirian' => ['type' => 'string', 'nullable' => true],
                'map' => ['type' => 'string'],
                'no_telp' => ['type' => 'string'],
                'instagram' => ['type' => 'string', 'nullable' => true],
                'facebook' => ['type' => 'string', 'nullable' => true],
                'tiktok' => ['type' => 'string', 'nullable' => true],
                'twitter' => ['type' => 'string', 'nullable' => true],
                'youtube' => ['type' => 'string', 'nullable' => true],
                'created_at' => ['type' => 'string', 'format' => 'date-time'],
                'updated_at' => ['type' => 'string', 'format' => 'date-time'],
            ],
        ],
        'Post' => [
            'type' => 'object',
            'properties' => [
                'id' => ['type' => 'integer'],
                'title' => ['type' => 'string'],
                'slug' => ['type' => 'string'],
                'content' => ['type' => 'string'],
                'image' => ['type' => 'string', 'nullable' => true],
                'created_at' => ['type' => 'string', 'format' => 'date-time'],
                'updated_at' => ['type' => 'string', 'format' => 'date-time'],
            ],
        ],
    ];

    private const DIVISION_PATHS = [
        '/kesiswaan',
        '/kurikulum',
        '/pramuka',
        '/keislaman',
        '/hubungan-industri',
        '/sarana-prasarana',
    ];

    public function ui(): View
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
            $uri = $route->uri();

            if (! str_starts_with($uri, 'api')) {
                continue;
            }

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

                $paths[$path][$method] = array_filter([
                    'tags' => [$this->tagFromPath($path)],
                    'summary' => $this->buildSummary($method, $path),
                    'operationId' => $this->operationId($httpMethod, $path),
                    'parameters' => $parameters !== [] ? $parameters : null,
                    'responses' => $this->buildResponses($path, $method),
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
            'components' => [
                'schemas' => self::SCHEMAS,
            ],
        ];

        return response()->json($spec);
    }

    private function toOpenApiPath(string $uri): ?string
    {
        $normalized = ltrim($uri, '/');

        if ($normalized === 'api') {
            return '/';
        }

        if (str_starts_with($normalized, 'api/')) {
            $rest = substr($normalized, 4);
            $rest = $rest === false ? '' : $rest;

            return '/'.ltrim($rest, '/');
        }

        return null;
    }

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

    private function buildSummary(string $method, string $path): string
    {
        $summaries = [
            'get' => [
                '/kesiswaan' => 'Ambil data Kesiswaan terbaru (termasuk foto profil & dokumen)',
                '/kurikulum' => 'Ambil data Kurikulum terbaru (termasuk foto profil & dokumen)',
                '/pramuka' => 'Ambil data Pramuka terbaru (termasuk foto profil & dokumen)',
                '/keislaman' => 'Ambil data Keislaman terbaru (termasuk foto profil & dokumen)',
                '/hubungan-industri' => 'Ambil data Hubungan Industri terbaru (termasuk foto profil & dokumen)',
                '/sarana-prasarana' => 'Ambil data Sarana dan Prasarana terbaru (termasuk foto profil & dokumen)',
                '/kepala-sekolah' => 'Ambil data Kepala Sekolah terbaru (termasuk foto profil & dokumen)',
            ],
        ];

        return $summaries[$method][$path] ?? strtoupper($method).' '.$path;
    }

    private function buildResponses(string $path, string $method): array
    {
        $okDescription = 'OK';

        if ($path === '/') {
            return [
                '200' => ['description' => $okDescription],
                '404' => ['description' => 'Not Found'],
            ];
        }

        $richPaths = [
            '/kesiswaan' => 'Division',
            '/kurikulum' => 'Division',
            '/pramuka' => 'Division',
            '/keislaman' => 'Division',
            '/hubungan-industri' => 'Division',
            '/sarana-prasarana' => 'Division',
            '/kepala-sekolah' => 'Division',
            '/profile' => 'Profile',
            '/photo' => 'Photo',
        ];

        if (isset($richPaths[$path]) && $method === 'get') {
            $schemaName = $richPaths[$path];

            return [
                '200' => [
                    'description' => $okDescription,
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'response' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'status' => ['type' => 'integer', 'example' => 200],
                                            'message' => ['type' => 'string'],
                                        ],
                                    ],
                                    'data' => ['$ref' => '#/components/schemas/'.$schemaName],
                                ],
                            ],
                        ],
                    ],
                ],
                '404' => [
                    'description' => 'Not Found',
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'response' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'status' => ['type' => 'integer', 'example' => 404],
                                            'message' => ['type' => 'string'],
                                        ],
                                    ],
                                    'data' => ['type' => 'null'],
                                ],
                            ],
                        ],
                    ],
                ],
            ];
        }

        return [
            '200' => ['description' => $okDescription],
            '404' => ['description' => 'Not Found'],
        ];
    }

    private function operationId(string $httpMethod, string $path): string
    {
        $id = strtolower($httpMethod).'_'.trim($path, '/');
        $id = str_replace(['/', '{', '}', '-', '.'], '_', $id);
        $id = preg_replace('/_+/', '_', $id) ?? $id;

        return $id === '' ? strtolower($httpMethod).'_root' : $id;
    }
}
