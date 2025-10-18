<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use Illuminate\Http\Request;

class KurikulumController extends Controller
{
    //
    public function index(){
        $kurikulum = Kurikulum::latest()->first();
        if($kurikulum){
            return response()->json([
                'response' => [
                    'status' => 200,
                    'message' => 'List Data Kurikulum'
                ], 'data' => $kurikulum
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
