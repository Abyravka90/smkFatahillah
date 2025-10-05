<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function index(){
        $categories = Category::latest()->paginate(10);
        return response()->json([
            'response' => [
                'status' => 200, 
                'message' => 'List Data Categories'
            ], 
            "data" => $categories
        ], 200);
    }

    public function show($slug){
        $category = Category::where('slug', $slug)->first();
        if($category){
            return response()->json([
                'response' => [
                    'status' => 200,
                    'message' => 'Data Berdasarkan Kategori '.$category->name,
                ], 'data' => $category->posts()->latest()->paginate(10),
            ], 200);
        } else {
            return response()->json([
                'response' => [
                    'status' => 404,
                    'message' => 'data berdasarkan kategori tidak ditemukan'
                ], 'data' => null,
            ], 404);
        }
    }
}
