<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeknikPemesinan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TPController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tps = TeknikPemesinan::latest()->paginate(1);
        $cek_tp = TeknikPemesinan::count();
        return view('admin.tp.index', compact('tps', 'cek_tp'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.tp.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'name' => 'required',
            'content' => 'required', 
            'image' => 'image|required'
        ]);

        $image = $request->file('image');
        $image->storeAs('tp', $image->hashName(), 'public');

        $tp = TeknikPemesinan::create([
            'name' => $request->input('name'),
            'content' => $request->input('content'),
            'image' => $image->hashName(),
        ]);

        if($tp){
            return redirect()->route('admin.tp.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        }else{
            return redirect()->route('admin.tp.index')->with(['error' => 'Data Gagal Ditambahkan']);
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
    public function edit(TeknikPemesinan $tp)
    {
        //
        return view('admin.tp.edit', compact('tp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeknikPemesinan $tp)
    {
        //
        $this->validate($request,[
        'name' => 'required',
        'content' => 'required',
        'image' => 'image|nullable'
        ]);

        if($request->file('image') == '' ){
            $tp->update([
                'name' => $request->input('name'),
                'content' => $request->input('content'),
            ]);
        }else{
            Storage::disk('public')->delete('tp/'.basename($tp->image));

            $image =  $request->file('image');
            $image->storeAs('tp', $image->hashName(), 'public');

            $tp->update([
                'name' => $request->input('name'),
                'content' => $request->input('content'),
                'image' => $image->hashName(),
            ]);

        }
        
        if($tp){
            return redirect()->route('admin.tp.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        }else{
           return redirect()->route('admin.tp.index')->with(['error' => 'Data Gagal Ditambahkan']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $tp = TeknikPemesinan::findOrFail($id);
        if($tp->image){
            Storage::disk('public')->delete('tp/'.basename($tp->image));
        }
        $tp->delete();
        if($tp){
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
