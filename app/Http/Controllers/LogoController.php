<?php

namespace App\Http\Controllers;

use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogoController extends Controller
{
    //

    public function __construct(){
        $this->middleware('permission:sliders.index')->only(['index']);
        $this->middleware('permission:sliders.create')->only(['store']);
        $this->middleware('permission:sliders.delete')->only(['destroy']);
    }

    public function index(){
        $logos = Logo::latest()->when(request()->q, function($logos){
            $logos = $logos->where('title', 'like', '%'.request()->q.'%');
        })->paginate(10);

        return view('admin.logo.index', compact('logos'));
    }

    public function create(){
        return view('admin.logo.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'image' => 'required|image'
        ]);

        
        $image = $request->file('image');
        $image->storeAs('logos', $image->hashName() ,'public');
        $logo = Logo::create([
            'title' => $request->input('title'),
            'image' => $image->hashName()
        ]);

        if($logo){
            return redirect()->route('admin.logo.index')->with(['success' => 'Data berhasil ditambahkan']);
        }else{
            return redirect()->route('admin.logo.index')->with(['error' => 'Data gagal ditambahkan']);
        }
    }

    public function destroy($id){
        $logo = Logo::findOrFail($id);
        Storage::disk('public')->delete('logos/'.basename($logo->image));
        $logo->delete();
        if($logo){
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
