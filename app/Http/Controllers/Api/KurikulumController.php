<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;

class KurikulumController extends Controller
{
    public function index()
    {
        $kurikulum = Kurikulum::with('documents')->latest()->first();

        if ($kurikulum) {
            return response()->json([
                'response' => [
                    'status' => 200,
                    'message' => 'List Data Kurikulum',
                ],
                'data' => $kurikulum,
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
