<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TeknikKomputerJaringan;
use Illuminate\Http\Request;

class TKJController extends Controller
{
    //
    public function index(){
        $tkj = TeknikKomputerJaringan::latest()->first();
        if($tkj){
            return response()->json([
                'response' => [
                    'status' => 200,
                    'message' => 'List Data TKJ'
                ], 'data' => $tkj
            ], 200);
        } else{
            return response()->json([
                'response' => [
                    'status' => 404,
                    'message' => 'Data Not Found'
                ], 'data' => null
            ], 404);
        }
    }
}
