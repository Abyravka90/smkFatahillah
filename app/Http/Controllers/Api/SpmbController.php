<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Spmb;
use Illuminate\Http\Request;

class SpmbController extends Controller
{
    //
    public function index(){
        $spmb = Spmb::latest()->paginate(10);
        return response()->json([
            'response' => [
                'status' => 200,
                'message' => 'List Data Spmb'
            ], 'data' => $spmb
        ], 200);
    }
}
