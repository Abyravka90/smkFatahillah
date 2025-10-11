<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    //
    public function index(){
        $jurusans = Jurusan::latest()->paginate(10);
        return view('admin.jurusan.index', compact('jurusans'));
    }

    public function create(){
        return view('admin.jurusan.create');       
    }

    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required'
        ]);

        $jurusan = Jurusan::create([
            'name' => $request->input('name'),
        ]);

        if($jurusan){
            return redirect()->route('admin.jurusan.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        } else {
            return redirect()->route('admin.jurusan.index')->with(['error' => 'Data Gagal Ditambahkan']);
        }
    }

    public function edit(Jurusan $jurusan){
        return view('admin.jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, Jurusan $jurusan){
        $this->validate($request,[
            'name' => 'required'
        ]);

        $jurusan->update([
            'name' => $request->input('name'),
        ]);

        if($jurusan){
            return redirect()->route('admin.jurusan.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        }else{
            return redirect()->route('admin.jurusan.index')->with(['error' => 'Data Gagal Ditambahkan']);
        }
    }

    public function destroy($id){
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();
        if($jurusan){
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
