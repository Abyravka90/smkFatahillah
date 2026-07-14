<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mikrotik;
use App\Http\Requests\Admin\UpdateMikrotikRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MikrotikController extends Controller
{
    public function index()
    {
        $mikrotik = Mikrotik::firstOrCreate([]);
        return view('admin.mikrotik.index', compact('mikrotik'));
    }

    public function edit()
    {
        $mikrotik = Mikrotik::firstOrCreate([]);
        return view('admin.mikrotik.edit', compact('mikrotik'));
    }

    public function update(UpdateMikrotikRequest $request)
    {
        $mikrotik = Mikrotik::firstOrCreate([]);
        
        // Ambil semua data yang valid, termasuk input teks
        $data = $request->validated();

        $image_fields = [
            'foto_kegiatan_1', 'foto_kegiatan_2', 'foto_kegiatan_3',
            'sertifikat_1', 'sertifikat_2', 'sertifikat_3', 'sertifikat_trainer'
        ];

        foreach ($image_fields as $field) {
            if ($request->hasFile($field)) {
                // Hapus file lama jika ada dan path-nya tersimpan
                if ($mikrotik->$field && Storage::disk('public')->exists($mikrotik->$field)) {
                    Storage::disk('public')->delete($mikrotik->$field);
                }
                // Simpan file baru dan perbarui path di array data
                $path = $request->file($field)->store('mikrotik', 'public');
                $data[$field] = $path;
            }
        }

        $mikrotik->update($data);

        return redirect()->route('admin.mikrotik.index')->with('success', 'Data Mikrotik berhasil diperbarui.');
    }
}
