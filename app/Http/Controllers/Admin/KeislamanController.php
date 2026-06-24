<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesDivisionUploads;
use App\Http\Controllers\Controller;
use App\Models\Keislaman;
use Illuminate\Http\Request;

class KeislamanController extends Controller
{
    use HandlesDivisionUploads;

    private string $folder = 'keislaman';

    public function __construct()
    {
        $this->middleware(['permission:keislaman.index'])->only(['index']);
        $this->middleware(['permission:keislaman.create'])->only(['create', 'store']);
        $this->middleware(['permission:keislaman.edit'])->only(['edit', 'update']);
        $this->middleware(['permission:keislaman.delete'])->only(['destroy']);
    }

    public function index()
    {
        $keislamans = Keislaman::with('documents')->latest()->paginate(1);
        $cek_keislaman = Keislaman::count();

        return view('admin.keislaman.index', compact('keislamans', 'cek_keislaman'));
    }

    public function create()
    {
        return view('admin.keislaman.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->divisionRules());

        $keislaman = Keislaman::create($this->storeDivisionData($request, $this->folder));
        $this->storeDivisionDocuments($request, $keislaman, $this->folder);

        if ($keislaman) {
            return redirect()->route('admin.keislaman.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        }

        return redirect()->route('admin.keislaman.index')->with(['error' => 'Data Gagal Ditambahkan']);
    }

    public function edit(Keislaman $keislaman)
    {
        $keislaman->load('documents');

        return view('admin.keislaman.edit', compact('keislaman'));
    }

    public function update(Request $request, Keislaman $keislaman)
    {
        $this->validate($request, $this->divisionRules());

        $keislaman->update($this->updateDivisionData($request, $keislaman, $this->folder));
        $this->storeDivisionDocuments($request, $keislaman, $this->folder);

        if ($keislaman) {
            return redirect()->route('admin.keislaman.index')->with(['success' => 'Data Berhasil Diupdate']);
        }

        return redirect()->route('admin.keislaman.index')->with(['error' => 'Data Gagal Diupdate']);
    }

    public function destroy(string $id)
    {
        $keislaman = Keislaman::with('documents')->findOrFail($id);
        $this->deleteDivisionFiles($keislaman, $this->folder);
        $keislaman->delete();

        if ($keislaman) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }
}
