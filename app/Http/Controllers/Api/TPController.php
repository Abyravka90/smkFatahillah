<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TeknikPemesinan;
use Illuminate\Http\Request;

class TPController extends Controller
{
    //
    public function index(){
        $tp = TeknikPemesinan::latest()->first();
        if($tp){
            return response()->json([
                'response' => [
                    'status' => 200,
                    'message' => 'List Data TP'
                ], 'data' => $tp
            ], 200);
        }else{
            return response()->json([
                'response' => [
                    'status' => 404,
                    'message' => 'Data Not Found'
                ], 'data' => null
            ], 404);
        }
    }
}
