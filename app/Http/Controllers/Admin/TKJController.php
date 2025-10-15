<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\TeknikKomputerJaringan;


class TKJController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tkjs = TeknikKomputerJaringan::latest()->paginate(1);
        $cek_tkj = TeknikKomputerJaringan::count();
        return view('admin.tkj.index', compact('tkjs', 'cek_tkj'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.tkj.create');
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
        $image->storeAs('tkj', $image->hashName(),'public');

        $tkj = TeknikKomputerJaringan::create([
             'name' => $request->input('name'),
            'content' => $request->input('content'),
            'image' => $image->hashName(),
        ]);

        if($tkj){
            return redirect()->route('admin.tkj.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        }else{
            return redirect()->route('admin.tkj.index')->with(['error' => 'Data Gagal Ditambahkan']);
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
    public function edit(TeknikKomputerJaringan $tkj)
    {
        //
        return view('admin.tkj.edit', compact('tkj'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeknikKomputerJaringan $tkj)
    {
        //
        $this->validate($request,[
        'name' => 'required',
        'content' => 'required',
        'image' => 'image|nullable'
        ]);

        if($request->file('image') == ''){
            $tkj->update([
                'name' => $request->input('name'),
                'content' => $request->input('content'),
            ]);
        }else{
            Storage::disk('public')->delete('tkj/'.basename(($tkj->image)));

            $image = $request->file('image');
            $image->storeAs('tkj', $image->hashName(), 'public');

            $tkj->update([
                'name' => $request->input('name'),
                'content' => $request->input('content'),
                'image' => $image->hashName(),
            ]);
        }
        if($tkj){
            return redirect()->route('admin.tkj.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        }else{
            return redirect()->route('admin.tkj.index')->with(['error' => 'Data Gagal Ditambahkan']);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $tkj = TeknikKomputerJaringan::findOrFail($id);
        if($tkj->image){
            Storage::disk('public')->delete('tkj/'.basename($tkj->image));
        }
        $tkj->delete();
        if($tkj){
            return response()->json([
                'status' => 'success'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
