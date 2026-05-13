<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Keislaman;
use Illuminate\Http\Request;

class KeislamanController extends Controller
{
    public function index()
    {
        $keislaman = Keislaman::latest()->first();

        if ($keislaman) {
            return response()->json([
                'response' => [
                    'status' => 200,
                    'message' => 'List Data Keislaman',
                ],
                'data' => $keislaman,
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

