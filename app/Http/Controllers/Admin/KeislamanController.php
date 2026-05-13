<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keislaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KeislamanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:keislaman.index'])->only(['index']);
        $this->middleware(['permission:keislaman.create'])->only(['create', 'store']);
        $this->middleware(['permission:keislaman.edit'])->only(['edit', 'update']);
        $this->middleware(['permission:keislaman.delete'])->only(['destroy']);
    }

    public function index()
    {
        $keislamans = Keislaman::latest()->paginate(1);
        $cek_keislaman = Keislaman::count();

        return view('admin.keislaman.index', compact('keislamans', 'cek_keislaman'));
    }

    public function create()
    {
        return view('admin.keislaman.create');
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
            $image->storeAs('keislaman', $image->hashName(), 'public');
            $data['image'] = $image->hashName();
        }

        $keislaman = Keislaman::create($data);

        if ($keislaman) {
            return redirect()->route('admin.keislaman.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        }

        return redirect()->route('admin.keislaman.index')->with(['error' => 'Data Gagal Ditambahkan']);
    }

    public function edit(Keislaman $keislaman)
    {
        return view('admin.keislaman.edit', compact('keislaman'));
    }

    public function update(Request $request, Keislaman $keislaman)
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
            if ($keislaman->getRawOriginal('image')) {
                Storage::disk('public')->delete('keislaman/' . basename($keislaman->getRawOriginal('image')));
            }

            $image = $request->file('image');
            $image->storeAs('keislaman', $image->hashName(), 'public');
            $data['image'] = $image->hashName();
        }

        $keislaman->update($data);

        if ($keislaman) {
            return redirect()->route('admin.keislaman.index')->with(['success' => 'Data Berhasil Diupdate']);
        }

        return redirect()->route('admin.keislaman.index')->with(['error' => 'Data Gagal Diupdate']);
    }

    public function destroy(string $id)
    {
        $keislaman = Keislaman::findOrFail($id);

        if ($keislaman->getRawOriginal('image')) {
            Storage::disk('public')->delete('keislaman/' . basename($keislaman->getRawOriginal('image')));
        }

        $keislaman->delete();

        if ($keislaman) {
            return response()->json([
                'status' => 'success',
            ]);
        }

        return response()->json([
            'status' => 'error',
        ]);
    }
}

