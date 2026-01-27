<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pramuka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PramukaController extends Controller
{
    //

    public function index()
    {
        $pramukas = Pramuka::latest()->paginate(1);
        $cek_pramuka = Pramuka::count();
        return view('admin.pramuka.index', compact('pramukas', 'cek_pramuka'));
    }

    public function create()
    {
        return view('admin.pramuka.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'image' => 'image',
            'name' => 'required',
            'content' => 'required',
        ]);

        if($request->has('image')){
            $image = $request->file('image');
            $image->storeAs('pramuka', $image->hashName(),'public');
            $pramukas = Pramuka::create([
                'name' => $request->input('name'),
                'content' => $request->input('content'),
                'image' => $image->hashName(),
            ]);
        }else{
            $pramukas = Pramuka::create([
                'name' => $request->input('name'),
                'content' => $request->input('content'),
            ]);
        }

        if($pramukas){
            return redirect()->route('admin.pramuka.index')->with('success', 'Data Berhasil Ditambahkan');
        }else{
            return redirect()->route('admin.pramuka.index')->with('error', 'Data gagal Ditambahkan');
        }
    }

    public function edit(Pramuka $pramuka)
    {
        return view('admin.pramuka.edit', compact('pramuka'));
    }

    public function update(Request $request, Pramuka $pramuka)
    {
        $this->validate($request, [
            'name' => 'required',
            'content' => 'required',
            'image' => 'nullable|image',
        ]);

        if($request->file('image') == ''){
            $pramuka->update([
                'name' => $request->input('name'),
                'content' => $request->input('content'),
            ]);
        }else{
            Storage::disk('public')->delete('pramuka/'.$pramuka->image);

            $image= $request->file('image');
            $image->storeAs('pramuka', $image->hashName(), 'public');

            $pramuka->update([
                'name' => $request->input('name'),
                'content' => $request->input('content'),
                'image' => $image->hashName(),
            ]);

            if($pramuka){
                return redirect()->route('admin.pramuka.index')->with('success', 'Data Berhasil Ditambahkan');
            }else{
                return redirect()->route('admin.pramuka.index')->with('error', 'Data Gagal Ditambahkan');
            }
        }
    }

    public function destroy(string $id)
    {
        $pramuka = Pramuka::findOrFail($id);
        if($pramuka->image){
            Storage::disk('public')->delete('pramuka/'.basename($pramuka->image));
        }
        $pramuka->delete();
        if($pramuka){
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
