<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    //
    public function __construct(){
        $this->middleware('permission:sliders.index')->only(['index']);
        $this->middleware('permission:sliders.create')->only(['store']);
        $this->middleware('permission:sliders.delete')->only(['destroy']);
    }

    public function index(){
        $sliders = Slider::latest()->when(request()->q, function($sliders){
            $sliders = $sliders->where('title', 'like', '%'.request()->q.'%');
        })->paginate(10);

        return view('admin.slider.index', compact('sliders'));
    }

    public function create(){
        return view('admin.slider.create');
    }

    public function store(Request $request){
        $this->validate($request,[
            'image' => 'required|image',
        ]);
        $image = $request->file('image');
        $image->storeAs('sliders', $image->hashName(), 'public');

        $sliders = Slider::create([
            'image' => $image->hashName()
        ]);

        if($sliders){
            return redirect()->route('admin.slider.index')->with(['success' => 'Data berhasil ditambahkan']);
        }else{
            return redirect()->route('admin.slider.index')->with(['error' => 'Data Gagal Ditambahkan']);
        }
    }

    public function destroy($id){
        $slider = Slider::findOrFail($id);
        $image = Storage::disk('public')->delete('sliders/'.basename($slider->image));
        $slider->delete();
        if($slider){
            return response()->json([
                'success' => 'success'
            ]);
        }else{
            return response()->json([
                'error' => 'error'
            ]);
        }
    }

}
