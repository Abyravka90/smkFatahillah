<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    //
    public function __construct(){
        $this->middleware('permission:categories.index')->only(['index']);
        $this->middleware('permission:categories.create')->only(['create', 'store']);
        $this->middleware('permission:categories.edit')->only(['edit', 'update']);
        $this->middleware('permission:categories.destroy')->only(['delete']);
    }   
    public function index(){
        $categories = Category::latest()->when(request()->q, function($categories){
            $categories = $categories->where('name','like','%'.request()->q.'%');
        })->paginate(10);

        return view('admin.category.index', compact('categories'));
    }

    public function create(){
        return view('admin.category.create');
    }   

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:categories'
        ]);

        $category = Category::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name'), '-'),
        ]);

        if($category){
            return redirect()->route('admin.category.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        }else{
            return redirect()->route('admin.category.index')->with(['error' => 'Data Gagal Ditambahkan']);
        }
    }

    public function edit(Category $category){
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, Category $category){
        $this->validate($request, [
            'name' => 'required|unique:categories,name,'.$category->id 
        ]);

        $category = Category::findOrFail($category->id);

        $category->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name'), '-'),
        ]);

        if($category){
            return redirect()->route('admin.category.index')->with(['success' => 'Data Berhasil Diupdate']);
        }else{
            return redirect()->route('admin.category.index')->with(['error' => 'Data Gagal Diupdate']);
        }
    }

    public function destroy(Category $category){
        $category = Category::findOrFail($category->id);
        $category->delete();

        if($category){
            return redirect()->route('admin.category.index')->with(['success' => 'Data Berhasil Dihapus']);
        }else{
            return redirect()->route('admin.category.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }

    
}
