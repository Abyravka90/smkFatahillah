<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kontributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KontributorController extends Controller
{
    //
    public function index(){
        $kontributors = Kontributor::with('jurusan')->latest()->paginate(10);
        $jurusans = Jurusan::all();
        return view(('admin.kontributor.index'), compact('kontributors'));
    }

    public function create(){
        $jurusans = Jurusan::all();
        return view('admin.kontributor.create', compact('jurusans'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'image_1' => 'image',
            'image_2' => 'image',
            'image_3' => 'image',
            'title' => 'required',
            'content' => 'required',
            'jurusan_id' => 'required|exists:jurusans,id',
        ]);

        $image_1 = $request->file('image_1');
        $image_1->storeAs('kontributor/image_1', $image_1->hashName(), 'public');
        $image_2 = $request->file('image_2');
        $image_2->storeAs('kontributor/image_2', $image_2->hashName(), 'public');
        $image_3 = $request->file('image_3');
        $image_3->storeAs('kontributor/image_3', $image_3->hashName(), 'public');

        $kontributor = Kontributor::create([
            'image_1' => $image_1->hashName(),
            'image_2' => $image_2->hashName(),
            'image_3' => $image_3->hashName(),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'jurusan_id' => $request->input('jurusan_id'),
        ]);

        if($kontributor){
            return redirect()->route('admin.kontributor.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        } else {
            return redirect()->route('admin.kontributor.index')->with(['error' => 'Data Gagal Ditambahkan']);
        }
    }

    public function edit(Kontributor $kontributor){
        $jurusans = Jurusan::all();
        return view(('admin.kontributor.edit'), compact('kontributor', 'jurusans'));
    }

    public function update(Request $request, Kontributor $kontributor){
        $this->validate($request,[
            'image_1' => 'image',
            'image_2' => 'image',
            'image_3' => 'image',
            'title' => 'required',
            'content' => 'required',
            'jurusan_id' => 'required|exists:jurusans,id',
        ]);

        if($request->hasFile('image_1')){
            $image_1 = $request->file('image_1');
            $image_1->storeAs('kontributor/image_1', $image_1->hashName(), 'public');
            $kontributor->image_1 = $image_1->hashName();
        }

        if($request->hasFile('image_2')){
            $image_2 = $request->file('image_2');
            $image_2->storeAs('kontributor/image_2', $image_2->hashName(), 'public');
            $kontributor->image_2 = $image_2->hashName();
        }

        if($request->hasFile('image_3')){
            $image_3 = $request->file('image_3');
            $image_3->storeAs('kontributor/image_3', $image_3->hashName(), 'public');
            $kontributor->image_3 = $image_3->hashName();
        }

        $kontributor->title = $request->input('title');
        $kontributor->content = $request->input('content');
        $kontributor->jurusan_id = $request->input('jurusan_id');
        $kontributor->save();

        return redirect()->route('admin.kontributor.index')->with(['success' => 'Data Berhasil Diupdate']);
    }

    public function destroy($id){
        $kontributor = Kontributor::findOrFail($id);
        Storage::disk('public')->delete('kontributor/image_1/'.basename($kontributor->image_1));
        Storage::disk('public')->delete('kontributor/image_2/'.basename($kontributor->image_2));
        Storage::disk('public')->delete('kontributor/image_3'.basename($kontributor->image_3));
        $kontributor->delete();
        if($kontributor){
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
