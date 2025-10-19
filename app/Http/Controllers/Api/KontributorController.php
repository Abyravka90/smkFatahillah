<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kontributor;
use Illuminate\Http\Request;

class KontributorController extends Controller
{
    //
    public function show($jurusan_id){
    $kontributors = Kontributor::where('jurusan_id', $jurusan_id)->latest()->paginate(5);

    if ($kontributors->count() > 0) {
        return response()->json([
            "response" => ["status" => 200, "message" => "List Data Kontributor"],
            "data" => $kontributors
        ], 200);
    }

    return response()->json([
        "response" => ["status" => 404, "message" => "Data tidak ditemukan"],
        "data" => null
    ], 404);
}
    }