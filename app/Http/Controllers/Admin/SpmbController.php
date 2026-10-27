<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Spmb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SpmbController extends Controller
{
    //
    public function index()
    {
        $spmbs = Spmb::latest()->paginate(10);

        return view('admin.spmb.index', compact('spmbs'));
    }

    public function create()
    {
        return view('admin.spmb.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'nullable|image',
            'file' => 'nullable|file|mimes:pdf',
            'link' => 'nullable',
            'title' => 'required',
            'content' => 'required',
        ]);

        $imageName = null;
        if ($request->file('image')) {
            $image = $request->file('image');
            $imageName = $image->hashName();
            $image->storeAs('spmb/image', $imageName, 'public');
        }

        $fileName = null;
        if ($request->file('file')) {
            $file = $request->file('file');
            $fileName = $file->hashName();
            $file->storeAs('spmb/file', $fileName, 'public');
        }

        $spmb = Spmb::create([
            'image' => $imageName,
            'file' => $fileName,
            'link' => $request->input('link'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);
        if ($spmb) {
            return redirect()->route('admin.spmb.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        } else {
            return redirect()->route('admin.spmb.index')->with(['error' => 'Data Gagal Ditambahkan']);
        }
    }

    public function edit(Spmb $spmb)
    {
        return view('admin.spmb.edit', compact('spmb'));
    }

    public function update(Request $request, Spmb $spmb)
    {
        $this->validate($request, [
            'image' => 'nullable|image',
            'file' => 'nullable|file|mimes:pdf',
            'link' => 'nullable',
            'title' => 'required',
            'content' => 'required',
        ]);

        $data = $request->only(['link', 'title', 'content']);

        // if has new image, store it and delete old one
        if ($request->hasFile('image')) {
            if ($spmb->image && Storage::disk('public')->exists('spmb/image/'.$spmb->image)) {
                Storage::disk('public')->delete('spmb/image/'.$spmb->image);
            }
            $image = $request->file('image');
            $imageName = $image->hashName();
            $image->storeAs('spmb/image', $imageName, 'public');
            $data['image'] = $imageName;
        }

        // if has new file, store it and delete old one
        if ($request->hasFile('file')) {
            if ($spmb->file && Storage::disk('public')->exists('spmb/file/'.$spmb->file)) {
                Storage::disk('public')->delete('spmb/file/'.$spmb->file);
            }
            $file = $request->file('file');
            $fileName = $file->hashName();
            $file->storeAs('spmb/file', $fileName, 'public');
            $data['file'] = $fileName;
        }

        $updated = $spmb->update($data);

        if ($updated) {
            return redirect()->route('admin.spmb.index')->with(['success' => 'Data Berhasil Diubah']);
        } else {
            return redirect()->route('admin.spmb.index')->with(['error' => 'Data Gagal Diubah']);
        }
    }

    public function destroy($id)
    {
        $spmb = Spmb::findOrFail($id);
        if ($spmb->image && Storage::disk('public')->exists('spmb/image/'.$spmb->image)) {
            Storage::disk('public')->delete('spmb/image/'.$spmb->image);
        }
        if ($spmb->file && Storage::disk('public')->exists('spmb/file/'.$spmb->file)) {
            Storage::disk('public')->delete('spmb/file/'.$spmb->file);
        }
        $spmb->delete();
        if ($spmb) {
            return response()->json([
                'status' => 'success',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
            ]);
        }
    }
}
