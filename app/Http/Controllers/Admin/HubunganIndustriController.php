<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HubunganIndustri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HubunganIndustriController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:hubunganindustri.index'])->only(['index']);
        $this->middleware(['permission:hubunganindustri.create'])->only(['create', 'store']);
        $this->middleware(['permission:hubunganindustri.edit'])->only(['edit', 'update']);
        $this->middleware(['permission:hubunganindustri.delete'])->only(['destroy']);
    }

    public function index()
    {
        $hubunganIndustris = HubunganIndustri::latest()->paginate(1);
        $cek_hubunganindustri = HubunganIndustri::count();

        return view('admin.hubunganindustri.index', compact('hubunganIndustris', 'cek_hubunganindustri'));
    }

    public function create()
    {
        return view('admin.hubunganindustri.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'content' => 'required',
            'image' => 'nullable|image',
        ]);

        $data = [
            'name' => $request->input('name'),
            'content' => $request->input('content'),
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('hubungan_industri', $image->hashName(), 'public');
            $data['image'] = $image->hashName();
        }

        $hubunganIndustri = HubunganIndustri::create($data);

        if ($hubunganIndustri) {
            return redirect()->route('admin.hubunganindustri.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        }

        return redirect()->route('admin.hubunganindustri.index')->with(['error' => 'Data Gagal Ditambahkan']);
    }

    public function edit(HubunganIndustri $hubunganindustri)
    {
        return view('admin.hubunganindustri.edit', ['hubunganindustri' => $hubunganindustri]);
    }

    public function update(Request $request, HubunganIndustri $hubunganindustri)
    {
        $this->validate($request, [
            'name' => 'required',
            'content' => 'required',
            'image' => 'nullable|image',
        ]);

        $data = [
            'name' => $request->input('name'),
            'content' => $request->input('content'),
        ];

        if ($request->hasFile('image')) {
            if ($hubunganindustri->getRawOriginal('image')) {
                Storage::disk('public')->delete('hubungan_industri/' . basename($hubunganindustri->getRawOriginal('image')));
            }

            $image = $request->file('image');
            $image->storeAs('hubungan_industri', $image->hashName(), 'public');
            $data['image'] = $image->hashName();
        }

        $hubunganindustri->update($data);

        if ($hubunganindustri) {
            return redirect()->route('admin.hubunganindustri.index')->with(['success' => 'Data Berhasil Diupdate']);
        }

        return redirect()->route('admin.hubunganindustri.index')->with(['error' => 'Data Gagal Diupdate']);
    }

    public function destroy(string $id)
    {
        $hubunganindustri = HubunganIndustri::findOrFail($id);

        if ($hubunganindustri->getRawOriginal('image')) {
            Storage::disk('public')->delete('hubungan_industri/' . basename($hubunganindustri->getRawOriginal('image')));
        }

        $hubunganindustri->delete();

        if ($hubunganindustri) {
            return response()->json([
                'status' => 'success',
            ]);
        }

        return response()->json([
            'status' => 'error',
        ]);
    }
}

