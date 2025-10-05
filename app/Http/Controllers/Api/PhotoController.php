<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    //
    public function index(){
        $photos = Photo::latest()->paginate(10);
        return response()->json([
            'response' => [
                'status' => 200,
                'message' => 'List Data Photo'
            ], 'data' => $photos
        ], 200);
    }

    public function PhotoHomePage(){
        $photos = Photo::latest()->take(2)->get();
        return response()->json([
            'response' => [
                'status' => 200,
                'message' => 'List Data HomePage'
            ], "data" => $photos
        ], 200);
    }
}
