<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class TagController extends Controller
{
    //
    public function __construct(){
        $this->middleware('permission:tags.index')->only(['index']);
        $this->middleware('permission:tags.create')->only(['create', 'store']);
        $this->middleware('permission:tags.edit')->only(['edit', 'update']);
        $this->middleware('permission:tags.destroy')->only(['delete']);
    }

    public function index(){
        $tags = Tag::latest()->when(request()->q, function($tags){
            $tags = $tags->where('name','like','%'.request()->q.'%');
        })->paginate(10);

        return view('admin.tag.index', compact('tags'));
    }

    public function create(){
        return view('admin.tag.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:tags'
        ]);

        $tag = Tag::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name'), '-'),
        ]);

        if($tag){
            return redirect()->route('admin.tag.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        }else{
            return redirect()->route('admin.tag.index')->with(['error' => 'Data Gagal Ditambahkan']);
        }
    }

    public function edit(Tag $tag){
        return view('admin.tag.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag){
        $this->alidate($request, [
            'name' => 'required|unique:tags,name,'.$tag->id 
        ]);

        $tag = Tag::findOrFail($tag->id);

        $tag->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name'), '-'),
        ]);

        if($tag){
            return redirect()->route('admin.tag.index')->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return redirect()->route('admin.tag.index')->with(['error' => 'Data Gagal Diupdate']);
        }
    }

    public function destroy(Tag $tag){
        $tag = Tag::findOrFail($tag->id);
        $tag->delete();
        if($tag){
            return response()->json([
                'status' => 'success'
            ]);             
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
