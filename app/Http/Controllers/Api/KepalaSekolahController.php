<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KepalaSekolah;

class KepalaSekolahController extends Controller
{
    public function index()
    {
        $kepalaSekolah = KepalaSekolah::with('documents')->latest()->first();

        if ($kepalaSekolah) {
            return response()->json([
                'response' => [
                    'status' => 200,
                    'message' => 'List Data Kepala Sekolah',
                ],
                'data' => $kepalaSekolah,
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
