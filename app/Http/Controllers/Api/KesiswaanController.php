<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kesiswaan;

class KesiswaanController extends Controller
{
    public function index()
    {
        $kesiswaan = Kesiswaan::with('documents')->latest()->first();

        if ($kesiswaan) {
            return response()->json([
                'response' => [
                    'status' => 200,
                    'message' => 'List Data Kesiswaan',
                ],
                'data' => $kesiswaan,
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
