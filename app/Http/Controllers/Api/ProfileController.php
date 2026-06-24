<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;

class ProfileController extends Controller
{
    //
    public function index()
    {
        $profile = Profile::latest()->first();
        if ($profile) {
            return response()->json([
                'response' => [
                    'status' => 200,
                    'message' => 'List Data Profile',
                ], 'data' => $profile,
            ], 200);
        } else {
            return response()->json([
                'response' => [
                    'status' => 404,
                    'message' => 'Data Not Found',
                ], 'data' => null,
            ], 404);
        }
    }
}
