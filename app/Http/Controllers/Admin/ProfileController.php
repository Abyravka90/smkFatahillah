<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::latest()->paginate(10);
        $cek_profile = Profile::count();
        return view('admin.profile.index', compact('profiles', 'cek_profile'));
    }

    public function create()
    {
        return view('admin.profile.create');
    }

    public function store(Request $request)
    {
        // Validation for new fields can be added here as well
        // For now, focusing on update

        // ... (store logic remains the same for now)
    }

    public function edit(Profile $profile)
    {
        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request, Profile $profile)
    {
        $this->validate($request, [
            'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg',
            'content' => 'required',
            'map' => 'required',
            'no_telp' => 'required',
            'struktur_organisasi_image' => 'image|mimes:jpeg,png,jpg', // Validation for new image
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
            'youtube' => $request->input('youtube'),
            // Add new text fields
            'sejarah_content' => $request->input('sejarah_content'),
            'visi_misi_content' => $request->input('visi_misi_content'),
            'hymne_fatahillah_content' => $request->input('hymne_fatahillah_content'),
            'mars_fatahillah_content' => $request->input('mars_fatahillah_content'),
        ];

        // Handle profile image upload
        if ($request->file('image')) {
            Storage::disk('public')->delete('profile/'.basename($profile->image));
            $image = $request->file('image');
            $image->storeAs('profile', $image->hashName(), 'public');
            $data['image'] = $image->hashName();
        }

        // Handle struktur_organisasi_image upload
        if ($request->file('struktur_organisasi_image')) {
            Storage::disk('public')->delete('struktur_organisasi/'.basename($profile->struktur_organisasi_image));
            $image = $request->file('struktur_organisasi_image');
            $image->storeAs('struktur_organisasi', $image->hashName(), 'public');
            $data['struktur_organisasi_image'] = $image->hashName();
        }

        $profile->update($data);

        if ($profile) {
            return redirect()->route('admin.profile.index')->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return redirect()->route('admin.profile.index')->with(['error' => 'Data Gagal Diupdate']);
        }
    }

    public function destroy($id)
    {
        $profile = Profile::findOrFail($id);

        if ($profile->image) {
            Storage::disk('public')->delete('profile/'.basename($profile->image));
        }
        if ($profile->struktur_organisasi_image) {
            Storage::disk('public')->delete('struktur_organisasi/'.basename($profile->struktur_organisasi_image));
        }

        $profile->delete();

        if ($profile) {
            return redirect()->route('admin.profile.index')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return redirect()->route('admin.profile.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}
