<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OTKP;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OTKPController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $otkps = OTKP::latest()->paginate(10);
        $cek_otkp = OTKP::count();
        return view('admin.otkp.index', compact('otkps', 'cek_otkp'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.otkp.create');
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

        //request dulu gambarnya
        $image = $request->file('image');

        //disimpan di storage
        $image->storeAs('otkp', $image->hashName(), 'public');

        //simpan di databse
        $otkps = OTKP::create([
            'name' => $request->input('name'),
            'content' => $request->input('content'),
            'image' => $image->hashName(),
        ]);
        if($otkps){
            return redirect()->route('admin.otkp.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        }else{
            return redirect()->route('admin.otkp.index')->with(['error' => 'Data Gagal ditambahkan']);
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
    public function edit(OTKP $otkp)
    {
        //
        return view('admin.otkp.edit', compact('otkp'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OTKP $otkp)
    {
        //
        $this->validate($request, [
            'name' => 'required',
            'content' => 'required',
            'image' => 'nullable|image',
        ]);

        if($request->file('image') == '' ){
            $otkp->update([
                'name' => $request->input('name'),
                'content' => $request->input('content'),
            ]);
        }else{
            // hapus file lama
            Storage::disk('public')->delete('otkp/'.basename($otkp->image));

            $image= $request->file('image');
            $image->storeAs('otkp', $image->hashName(), 'public');

            $otkp->update([
                'name' => $request->input('name'),
                'content' => $request->input('content'),
                'image' => $image->hashName(),
            ]);

            if($otkp){
                return redirect()->route('admin.otkp.index')->with(['success' => 'Data Berhasil Ditambahkan']);
            }else{
                return redirect()->route('admin.otkp.index')->with(['error' => 'Data Gagal Ditambahkan']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $otkp = OTKP::findOrFail($id);

        if($otkp->image){
            Storage::disk('public')->delete('otkp/'.basename($otkp->image));
        }
        $otkp->delete();
        if($otkp){
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
