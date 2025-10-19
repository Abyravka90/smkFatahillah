<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    //
    public function index(){
        $jurusans = Jurusan::latest()->paginate(10);
        if($jurusans->count() > 0){
            return response()->json([
                'response' => [
                    'status' => 200,
                    'message' => 'List Data Jurusan'
                ], 'data' => $jurusans
            ], 200);
        } else {
            return response()->json([
                'response' => [
                    'status' => 404,
                    'message' => 'Data Jurusan Tidak ditemukan'
                ], 'data' => null
            ], 404);
        }
    }
}
