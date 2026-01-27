<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pramuka;
use Illuminate\Http\Request;

class PramukaController extends Controller
{
    //
    public function index(){
        $pramuka = Pramuka::latest()->first();
        if($pramuka){
            return response()->json([
                'response' => [
                    'status' => 200,
                    'message' => 'List Data Pramuka'
                ], 'data' => $pramuka
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
