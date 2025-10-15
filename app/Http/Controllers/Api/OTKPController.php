<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OTKP;
use Illuminate\Http\Request;

class OTKPController extends Controller
{
    //
    public function index(){
        $otkp = OTKP::latest()->first();
        if($otkp){
            return response()->json([
                'response' => [
                    'status' => 200, 
                    'message' => 'List Data OTKP'
                ], 'data' => $otkp
            ], 200);
        } else {
            return response()->json([
                'response' => [
                    'status' => 404,
                    'message' => 'Data Not Found'
                ], 'data' => null
            ], 404);
        }
    }
}
