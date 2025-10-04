<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    //
    public function __construct(){
        $this->middleware('permission:posts.index')->only('index');
        $this->middleware('permission:posts.create')->only(['create', 'store']);
        $this->middleware('permission:posts.edit')->only('edit', 'update');
        $this->middleware('permission:posts.destroy')->only('delete');
    }

    public function index(){
        $posts = Post::latest()->when(request()->q, function($posts){
            $posts = $posts->where('title', 'like', '%'.request()->q.'%');
        })->paginate(10);

        return view('admin.post.index', compact('posts'));
    }

    public function create(){
        $tags = Tag::latest()->get();
        $categories = Category::latest()->get();

        return view('admin.post.create', compact('tags', 'categories'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'title' => 'required|unique:posts',
            'category_id' => 'required',   
            'content' => 'required',
        ]);

        $image = $request->file('image');

        $image->storeAs('posts', $image->hashName(),'public');

        $post = Post::create([
            'image' => $image->hashName(),
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title'), '-'),
            'category_id' => $request->input('category_id'),
            'content' => $request->input('content'),
        ]);

        $post->tags()->attach($request->input('tags'));
        $post->save();

        if($post){
            return redirect()->route('admin.post.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        } else {
            return redirect()->route('admin.post.index')->with(['error' => 'Data gagal Ditambahkan']);
        }
    }

    public function edit(Post $post){
        $tags = Tag::latest()->get();
        $categories = Category::latest()->get();
        return view('admin.post.edit', compact('post', 'tags', 'categories'));
    }

    public function update(Request $request, Post $post){
        $this->validate($request,[
            'title' => 'required|unique:posts,title,'.$post->id,
            'category_id' => 'required',
            'content' => 'required',  
        ]);
        if($request->file('image') == '' ){
            $post = Post::findOrFail($post->id);
            $post->update([
                'title' => $request->input('title'),
                'slug' => Str::slug($request->input('title'),'-'),
                'category_id' => $request->input('category_id'),
                'content' => $request->input('content'),
            ]);
        }else{
            // remove old picture
            Storage::disk('public')->delete('posts/'.basename($post->id));

            // upload new image
            $image = $request->file('image');
            $image->storeAs('posts', $image->hashName(), 'public');

            // update the file
            $post = Post::findOrFail($post->id);
            $post->update([
                'image' => $image->hashName(),
                'title' => $request->input('title'),
                'slug' => Str::slug($request->input('title'),'-'),
                'category_id' => $request->input('category_id'),
                'content' => $request->input('content'), 
            ]);
        }

        $post->tags()->sync($request->input('tags'));

        if($post){
            return redirect()->route('admin.post.index')->with(['success' => 'Data Berhasil di update']);
        }else{
            return redirect()->route('admin.post.index')->with(['error' => 'Data Gagal di upload']);
        }
    }

    public function destroy($id){
        $post = Post::findOrFail($id);
        Storage::disk('public')->delete('/posts'.basename($post->image));
        $post->delete();
        if($post){
            return response()->json([
                'success' => 'Data berhasil dihapus'
            ]);
        }else{
            return response()->json([
                'error' => 'Data Gagal Dihapus'
            ]);
        } 
    }

}
