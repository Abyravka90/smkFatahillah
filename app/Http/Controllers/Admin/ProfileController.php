<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    //
    public function index(){
        $profiles = Profile::query()->latest()->paginate(10);
        $cek_profile = Profile::count();
        return view('admin.profile.index', compact('profiles', 'cek_profile'));
    }

    public function create(){
        return view('admin.profile.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'izin_operasional' => 'file|mimes:pdf',
            'izin_pendirian' => 'file|mimes:pdf',
            'image' => 'image|mimes:jpeg,png,jpg',
            'content' => 'required',
            'map' => 'required',
            'no_telp' => 'required'
        ]);

        $izin_operasional = $request->file('izin_operasional');
        $izin_operasional->storeAs('izin_operasional', $izin_operasional->hashName(), 'public');

        $izin_pendirian = $request->file('izin_pendirian');
        $izin_pendirian->storeAs('izin_pendirian', $izin_pendirian->hashName(), 'public');

        $image = $request->file('image');
        $image->storeAs('profile', $image->hashName(), 'public');

        $profile = Profile::create([
            'name' => $request->input('name'),
            'izin_operasional' => $izin_operasional->hashName(),
            'izin_pendirian' => $izin_pendirian->hashName(),
            'image' => $image->hashName(),
            'content' => $request->input('content'),
            'map' => $request->input('map'),
            'instagram' => $request->input('instagram'),
            'facebook' => $request->input('facebook'),
            'tiktok' => $request->input('tiktok'),
            'twitter' => $request->input('twitter'),
            'no_telp' => $request->input('no_telp'),
        ]);

        if($profile){
            return redirect()->route('admin.profile.index')->with(['success' => 'Data Berhasil ditambahkan']);
        }else{
            return redirect()->route('admin.profile.index')->with(['error' => 'Data Gagal Ditambahkan']);
        }
    }

    public function edit(Profile $profile){
        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request, Profile $profile){
        $this->validate($request, [
            'name' => 'required',
            'izin_operasional' => 'file|mimes:pdf',
            'izin_pendirian' => 'file|mimes:pdf',
            'image' => 'image|mimes:jpeg,png,jpg',
            'content' => 'required',
            'map' => 'required',
            'no_telp' => 'required'
        ]);
        $data = [
            'name' => $request->input('name'),
            'content' => $request->input('content'),
            'map' => $request->input('map'),
            'instagram' => $request->input('instagram'),
            'facebook' => $request->input('facebook'),
            'tiktok' => $request->input('tiktok'),
            'twitter' => $request->input('twitter'),
            'no_telp' => $request->input('no_telp'),
        ];
        
        // Handle image upload
        if ($request->file('image')) {
            Storage::disk('public')->delete('profile/' . basename($profile->image));
            $image = $request->file('image');
            $image->storeAs('profile', $image->hashName(), 'public');
            $data['image'] = $image->hashName();
        }

        // Handle izin_operasional upload
        if ($request->file('izin_operasional')) {
            Storage::disk('public')->delete('izin_operasional/' . basename($profile->izin_operasional));
            $izin_operasional = $request->file('izin_operasional');
            $izin_operasional->storeAs('izin_operasional', $izin_operasional->hashName(), 'public');
            $data['izin_operasional'] = $izin_operasional->hashName();
        }

        // Handle izin_pendirian upload
        if ($request->file('izin_pendirian')) {
            Storage::disk('public')->delete('izin_pendirian/' . basename($profile->izin_pendirian));
            $izin_pendirian = $request->file('izin_pendirian');
            $izin_pendirian->storeAs('izin_pendirian', $izin_pendirian->hashName(), 'public');
            $data['izin_pendirian'] = $izin_pendirian->hashName();
        }
    
        $profile->update($data);
        if($profile){
            return redirect()->route('admin.profile.index')->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return redirect()->route('admin.profile.index')->with(['error' => 'Data Gagal Diupdate']);
        }
    }

    public function destroy($id){
        $profile = Profile::findOrFail($id);

        // Delete files if exist
        if ($profile->image) {
            Storage::disk('public')->delete('profile/' . basename($profile->image));
        }
        if ($profile->izin_operasional) {
            Storage::disk('public')->delete('izin_operasional/' . basename($profile->izin_operasional));
        }
        if ($profile->izin_pendirian) {
            Storage::disk('public')->delete('izin_pendirian/' . basename($profile->izin_pendirian));
        }

        $profile->delete();
        if($profile){
            return redirect()->route('admin.profile.index')->with(['success' => 'Data Berhasil Dihapus']);
        }else{
            return redirect()->route('admin.profile.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}
