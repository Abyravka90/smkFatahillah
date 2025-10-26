<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FasilitasController extends Controller
{
    //
    public function index(){
        $fasilitas = Fasilitas::latest()->paginate(10);
        return view('admin.fasilitas.index', compact('fasilitas'));
    }
    public function create(){
        return view('admin.fasilitas.create');
    }
    public function store(Request $request){
        $this->validate($request,[
          'title' => 'required',
          'image' => 'image|required'  
        ]);

        $image = $request->file('image');
        $image->storeAs('fasilitas', $image->hashName(), 'public');

        $fasilitas = Fasilitas::create([
            'title' => $request->input('title'),
            'image' => $image->hashName()
        ]);
        if($fasilitas){
            return redirect()->route('admin.fasilitas.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        }else{
            return redirect()->route('admin.fasilitas.index')->with(['error' => 'Data Gagal Ditambahkan']);
        }
    }
    // public function edit(Fasilitas $fasilitas){
    //     return view('admin.fasilitas.edit', compact('fasilitas'));
    // }
    // public function update(Request $request, Fasilitas $fasilitas){
    //     $this->validate($request,[
    //         'title' => 'required',
    //         'image' => 'nullable|image',
    //     ]);
    //     if($request->file('image')){
    //         Storage::disk('public')->delete('fasilitas/'.basename($fasilitas->image));
    //         $image = $request->file('image');
    //         $image->storeAs('fasilitas', $image->hashName(), 'public');
    //         $fasilitas->update([
    //             'title' => $request->input('title'),
    //             'image' => $image->hashName(),
    //         ]);
    //     }else{
    //         $fasilitas->update([ 'title' => $request->input('title')]);
    //     }
    //     if($fasilitas){
    //         return redirect()->route('admin.fasilitas.index')->with(['success' => 'Data Berhasil di Update']);
    //     }else{
    //         return redirect()->route('admin.fasilitas.index')->with(['error' => 'Data Gagal Di update']);
    //     }

    // }

    public function destroy($id){
        $fasilitas = Fasilitas::findOrFail($id);
        if($fasilitas->image){
            Storage::disk('public')->delete('fasilitas/'.basename($fasilitas->image));
        }
        $fasilitas->delete();
        if($fasilitas){
            return response()->json([
                'status' => 'success'
            ]);
        }else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
