<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pramuka;

class PramukaController extends Controller
{
    public function index()
    {
        $pramuka = Pramuka::with('documents')->latest()->first();

        if ($pramuka) {
            return response()->json([
                'response' => [
                    'status' => 200,
                    'message' => 'List Data Pramuka',
                ],
                'data' => $pramuka,
            ], 200);
        }

        return response()->json([
            'response' => [
                'status' => 404,
                'message' => 'Data Not Found',
            ],
            'data' => null,
        ], 404);
    }
}
