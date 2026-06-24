<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SaranaPrasarana;

class SaranaPrasaranaController extends Controller
{
    public function index()
    {
        $saranaPrasarana = SaranaPrasarana::with('documents')->latest()->first();

        if ($saranaPrasarana) {
            return response()->json([
                'response' => [
                    'status' => 200,
                    'message' => 'List Data Sarana dan Prasarana',
                ],
                'data' => $saranaPrasarana,
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
