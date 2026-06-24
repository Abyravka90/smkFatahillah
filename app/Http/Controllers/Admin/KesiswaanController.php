<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesDivisionUploads;
use App\Http\Controllers\Controller;
use App\Models\Kesiswaan;
use Illuminate\Http\Request;

class KesiswaanController extends Controller
{
    use HandlesDivisionUploads;

    private string $folder = 'kesiswaan';

    public function __construct()
    {
        $this->middleware(['permission:kesiswaan.index'])->only(['index']);
        $this->middleware(['permission:kesiswaan.create'])->only(['create', 'store']);
        $this->middleware(['permission:kesiswaan.edit'])->only(['edit', 'update']);
        $this->middleware(['permission:kesiswaan.delete'])->only(['destroy']);
    }

    public function index()
    {
        $kesiswaans = Kesiswaan::with('documents')->latest()->paginate(1);
        $cek_kesiswaan = Kesiswaan::count();

        return view('admin.kesiswaan.index', compact('kesiswaans', 'cek_kesiswaan'));
    }

    public function create()
    {
        return view('admin.kesiswaan.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->divisionRules());

        $kesiswaan = Kesiswaan::create($this->storeDivisionData($request, $this->folder));
        $this->storeDivisionDocuments($request, $kesiswaan, $this->folder);

        if ($kesiswaan) {
            return redirect()->route('admin.kesiswaan.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        }

        return redirect()->route('admin.kesiswaan.index')->with(['error' => 'Data Gagal Ditambahkan']);
    }

    public function edit(Kesiswaan $kesiswaan)
    {
        $kesiswaan->load('documents');

        return view('admin.kesiswaan.edit', compact('kesiswaan'));
    }

    public function update(Request $request, Kesiswaan $kesiswaan)
    {
        $this->validate($request, $this->divisionRules());

        $kesiswaan->update($this->updateDivisionData($request, $kesiswaan, $this->folder));
        $this->storeDivisionDocuments($request, $kesiswaan, $this->folder);

        if ($kesiswaan) {
            return redirect()->route('admin.kesiswaan.index')->with(['success' => 'Data Berhasil Diupdate']);
        }

        return redirect()->route('admin.kesiswaan.index')->with(['error' => 'Data Gagal Diupdate']);
    }

    public function destroy($id)
    {
        $kesiswaan = Kesiswaan::with('documents')->findOrFail($id);
        $this->deleteDivisionFiles($kesiswaan, $this->folder);
        $kesiswaan->delete();

        if ($kesiswaan) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }
}
