<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    //
    public function __construct(){
        $this->middleware('permission:videos.index')->only(['index']);
        $this->middleware('permission:videos.create')->only(['create','store']);
        $this->middleware('permission:videos.edit')->only(['edit', 'update']);
        $this->middleware('permission:videos.delete')->only(['destroy']);
    }
    public function index(){
        $videos = Video::latest()->when(request()->q, function($videos){
            $videos = $videos('name','like', '%'.request()->q.'%');
        })->paginate(10);

        return view('admin.video.index', compact('videos'));
    }

    public function create(){
        return view('admin.video.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'embbed' => 'required'
        ]);

        $video = Video::create([
            'title' => $request->input('title'),
            'embbed' => $request->input('embbed'),
        ]);

        if($video){
            return redirect()->route('admin.video.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        } else {
            return redirect()->route('admin.video.index')->with(['error' => 'Data Gagal Ditambahkan']);
        }
    }

    public function edit(Video $video){
        $video = Video::findOrFail($video->id);
        return view('admin.video.edit', compact('video'));
    }

    public function update(Request $request, Video $video){
        $this->validate($request, [
            'title' => 'required',
            'embbed' => 'required'
        ]);

        $video = Video::findOrFail($video->id);
        $video->update([
            'title' => $request->input('title'),
            'embbed' => $request->input('embbed'),
        ]);

        if($video){
            return redirect()->route('admin.video.index')->with(['success' => 'Data berhasil di update']);
        } else {
            return redirect()->route('admin.video.index')->with(['error' => 'Data gagal di update']);
        }
    }

    public function destroy($id){
        $video = Video::findOrFail($id);
        $video->delete();
        if($video){
            return response()->json([
                'success' => 'Data Berhasil dihapus'
            ]);
        }else {
            return response()->json([
                'error' => 'Data berhasil dihapus'
            ]);
        }
    }

}
