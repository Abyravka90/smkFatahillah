<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HubunganIndustri;

class HubunganIndustriController extends Controller
{
    public function index()
    {
        $hubunganIndustri = HubunganIndustri::with('documents')->latest()->first();

        if ($hubunganIndustri) {
            return response()->json([
                'response' => [
                    'status' => 200,
                    'message' => 'List Data Hubungan Industri',
                ],
                'data' => $hubunganIndustri,
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
