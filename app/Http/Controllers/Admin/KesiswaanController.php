<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kesiswaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KesiswaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $kesiswaans = Kesiswaan::latest()->paginate(1);
        $cek_kesiswaan = Kesiswaan::count();
        return view('admin.kesiswaan.index', compact('kesiswaans','cek_kesiswaan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.kesiswaan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'image' => 'image',
            'name' => 'required',
            'content' => 'required',
        ]);

        $image = $request->file('image');
        $image->storeAs('kesiswaan', $image->hashName(),'public');

        $kesiswaan = Kesiswaan::create([
            'name' => $request->input('name'),
            'content' => $request->input('content'),
            'image' => $image->hashName(),
        ]);

        if($kesiswaan){
            return redirect()->route('admin.kesiswaan.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        }else{
            return redirect()->route('admin.kesiswaan.index')->with(['error' => 'Data Gagal Ditambahkan']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kesiswaan $kesiswaan)
    {
        //
        return view('admin.kesiswaan.edit', compact('kesiswaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kesiswaan $kesiswaan)
    {
        //
        $this->validate($request,[
            'image' => 'image',
            'name' => 'required',
            'content' => 'required',
        ]);

        if($request->file('image') == '' ){
            $kesiswaan->update([
                'name' => $request->input('name'),
                'content' => $request->input('content'),
            ]);
        }else{
            Storage::disk('public')->delete('kesiswaan/'.basename($kesiswaan->image));
            $image =  $request->file('image');
            $image->storeAs('kesiswaan', $image->hashName(), 'public');

            $kesiswaan->update([
                'name' => $request->input('name'),
                'content' => $request->input('content'),
                'image' => $image->hashName(),
            ]);
        }
        if($kesiswaan){
            return redirect()->route('admin.kesiswaan.index')->with(['success' => 'Data Berhasil Diupdate']);
        }else{
            return redirect()->route('admin.kesiswaan.index')->with(['error' => 'Data Gagal Diupdate']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $kesiswaan = Kesiswaan::findOrFail($id);
        Storage::disk('public')->delete('kesiswaan/'.basename($kesiswaan->image));
        $kesiswaan->delete();
        if($kesiswaan)
        {
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
