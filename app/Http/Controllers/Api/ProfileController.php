<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    public function index(){
        $profile = Profile::latest()->first();
        return response()->json([
            'response' => [
                'status' => 200, 
                'message' => 'List Data Profile'
            ], 'data' => $profile
        ],200);  
    }
}
