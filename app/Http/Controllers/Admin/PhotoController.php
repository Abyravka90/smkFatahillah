<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    //
    public function __construct(){
        $this->middleware('permission:photos.index')->only(['index']);
        $this->middleware('permission:photos.create')->only(['store']);
        $this->middleware('permission:photos.delete')->only(['destroy']);
    }

    public function index(){
        $photos = Photo::latest()->when(request()->q, function($photos) {
            $photos = $photos->where('title', 'like', '%'. request()->q .'%');
        })->paginate(10);

        return view('admin.photo.index', compact('photos'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'image' => 'required|image',
            'caption' => 'required'
        ]);

        $image = $request->file('image');
        $image->storeAs('photos', $image->hashName(), 'public');

        $photos = Photo::create([
            'image' => $image->hashName(),
            'caption' => $request->input('caption'),
        ]);

        if($photos){
            return redirect()->route('admin.photo.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        } else {
            return redirect()->route('admin.photo.index')->with(['success' => 'Data Gagal Ditambahkan']);
        }
    }

    public function destroy($id){
        $photo = Photo::findOrFail($id);
        Storage::disk('public')->delete('photos/'.basename($photo->image));
        $photo->delete();

        if($photo){
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
