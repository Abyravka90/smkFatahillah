<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesDivisionUploads;
use App\Http\Controllers\Controller;
use App\Models\KepalaSekolah;
use Illuminate\Http\Request;

class KepalaSekolahController extends Controller
{
    use HandlesDivisionUploads;

    private string $folder = 'kepala_sekolah';

    public function __construct()
    {
        $this->middleware(['permission:kepalasekolah.index'])->only(['index']);
        $this->middleware(['permission:kepalasekolah.create'])->only(['create', 'store']);
        $this->middleware(['permission:kepalasekolah.edit'])->only(['edit', 'update']);
        $this->middleware(['permission:kepalasekolah.delete'])->only(['destroy']);
    }

    public function index()
    {
        $kepalaSekolahs = KepalaSekolah::with('documents')->latest()->paginate(1);
        $cek_kepalasekolah = KepalaSekolah::count();

        return view('admin.kepalasekolah.index', compact('kepalaSekolahs', 'cek_kepalasekolah'));
    }

    public function create()
    {
        return view('admin.kepalasekolah.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->divisionRules());

        $kepalaSekolah = KepalaSekolah::create($this->storeDivisionData($request, $this->folder));
        $this->storeDivisionDocuments($request, $kepalaSekolah, $this->folder);

        if ($kepalaSekolah) {
            return redirect()->route('admin.kepalasekolah.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        }

        return redirect()->route('admin.kepalasekolah.index')->with(['error' => 'Data Gagal Ditambahkan']);
    }

    public function edit(KepalaSekolah $kepalasekolah)
    {
        $kepalasekolah->load('documents');

        return view('admin.kepalasekolah.edit', compact('kepalasekolah'));
    }

    public function update(Request $request, KepalaSekolah $kepalasekolah)
    {
        $this->validate($request, $this->divisionRules());

        $kepalasekolah->update($this->updateDivisionData($request, $kepalasekolah, $this->folder));
        $this->storeDivisionDocuments($request, $kepalasekolah, $this->folder);

        if ($kepalasekolah) {
            return redirect()->route('admin.kepalasekolah.index')->with(['success' => 'Data Berhasil Diupdate']);
        }

        return redirect()->route('admin.kepalasekolah.index')->with(['error' => 'Data Gagal Diupdate']);
    }

    public function destroy(string $id)
    {
        $kepalasekolah = KepalaSekolah::with('documents')->findOrFail($id);
        $this->deleteDivisionFiles($kepalasekolah, $this->folder);
        $kepalasekolah->delete();

        if ($kepalasekolah) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }
}
