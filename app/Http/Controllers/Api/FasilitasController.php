<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;

class FasilitasController extends Controller
{
    //
    public function index()
    {
        $fasilitas = Fasilitas::latest()->paginate(10);

        return response()->json([
            'response' => [
                'status' => 200,
                'message' => 'List Data Fasilitas',
            ], 'data' => $fasilitas,
        ], 200);
    }
}
