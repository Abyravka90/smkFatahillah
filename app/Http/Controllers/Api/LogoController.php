<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;

class LogoController extends Controller
{
    //
    public function index(){
        $logos = Logo::latest()->paginate(10);
        return response()->json([
            'repsonse' => [
                'status' => 200,
                'message' => 'List Data Logo'
            ], 'data' => $logos
        ], 200);
    }

    public function LogoHomePage(){
        $logos = Logo::latest()->take(4)->get();
        return response()->json([
            'response' => [
              'status' => 200,
              'message' => 'List Data HomePage' 
            ], 'data' => $logos
        ], 200);
    }
}
