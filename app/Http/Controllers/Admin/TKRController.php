<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeknikKendaraanRingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TKRController extends Controller
{
    /**
     * Display a listing of the resource 
     */
    public function index()
    {
        //
        $tkrs = TeknikKendaraanRingan::latest()->paginate(1);
        $cek_tkr = TeknikKendaraanRingan::count();
        return view('admin.tkr.index', compact('tkrs', 'cek_tkr'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.tkr.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'image' => 'image',
            'name' => 'required',
            'content' => 'required'
        ]);

        $image = $request->file('image');

        $image->storeAs('tkr', $image->hashName(), 'public');

        $tkr = TeknikKendaraanRingan::create([
            'name' => $request->input('name'),
            'content' => $request->input('content'),
            'image' => $image->hashName()
        ]);

        if($tkr){
            return redirect()->route('admin.tkr.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        }else{
            return redirect()->route('admin.tkr.index')->with(['error' => 'Data Gagal Ditambahkan']);
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
    public function edit(TeknikKendaraanRingan $tkr)
    {
        //
        return view('admin.tkr.edit', compact('tkr'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeknikKendaraanRingan $tkr)
    {
        //
        $this->validate($request, [
            'name' => 'required',
            'content' => 'required',
            'image' => 'image|nullable'
        ]);

        if($request->file('image') == ''){
            $tkr->update([
                'name' => $request->input('name'),
                'content' => $request->input('content')
            ]); 
        }else{
            Storage::disk('public')->delete('tkr/'.basename($tkr->image));

            $image = $request->file('image');
            $image->storeAs('tkr', $image->hashName(), 'public');

            $tkr->update([
                'name' => $request->input('name'),
                'content' => $request->input('content'),
                'image' => $image->hashName()
            ]);

            if($tkr){
                return redirect()->route('admin.tkr.index')->with(['success' => 'Data Berhasil Ditambahkan']);
            }else{
                return redirect()->route('admin.tkr.index')->with(['error' => 'Data Gagal Ditambahkan']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $tkr = TeknikKendaraanRingan::findOrFail($id);
        $tkr->delete();
        if($tkr){
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
