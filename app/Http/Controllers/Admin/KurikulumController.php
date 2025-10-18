<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KurikulumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $kurikulums = Kurikulum::latest()->paginate(1);
        $cek_kurikulum = Kurikulum::count();
        return view('admin.kurikulum.index', compact('kurikulums', 'cek_kurikulum'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.kurikulum.create');
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
        $image->storeAs('kurikulum', $image->hashName(), 'public');

        $kurikulum = Kurikulum::create([
            'name' => $request->input('name'),
            'content' => $request->input('content'),
            'image' => $image->hashName(),
        ]);

        if($kurikulum){
            return redirect()->route('admin.kurikulum.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        }else {
            return redirect()->route('admin.kurikulum.index')->with(['error' => 'Data Gagal Ditambahkan']);
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
    public function edit(Kurikulum $kurikulum)
    {
        //
        return view('admin.kurikulum.edit', compact('kurikulum'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kurikulum $kurikulum)
    {
        //
        $this->validate($request, [
            'image' => 'image',
            'name' => 'required',
            'content' => 'required',
        ]);

        if($request->file('image') == ''){
            $kurikulum->update([
                'name' => $request->input('name'),
                'content' => $request->input('content')
            ]);
        }else{
            Storage::disk('public')->delete('kurikulum/'.basename($kurikulum->image));
            $image = $request->file('image');
            $image->storeAs('kurikulum', $image->hashName(), 'public');
            $kurikulum->update([
                'name' => $request->input('name'),
                'content' => $request->input('content'),
                'image' => $image->hashName(),
            ]);
        }
        if($kurikulum){
            return redirect()->route('admin.kurikulum.index')->with(['success' => 'Data Berhasil Diupdate']);
        }else{
            return redirect()->route('admin.kurikulum.index')->with(['error' => 'Data Gagal Diupdate']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $kurikulum = Kurikulum::findOrFail($id);
        Storage::disk('public')->delete('kurikulum/'.basename($kurikulum->image));
        $kurikulum->delete();
        if($kurikulum){
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
