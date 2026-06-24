<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesDivisionUploads;
use App\Http\Controllers\Controller;
use App\Models\Pramuka;
use Illuminate\Http\Request;

class PramukaController extends Controller
{
    use HandlesDivisionUploads;

    private string $folder = 'pramuka';

    public function __construct()
    {
        $this->middleware(['permission:pramuka.index|pramukas.index'])->only(['index']);
        $this->middleware(['permission:pramuka.create|pramukas.create'])->only(['create', 'store']);
        $this->middleware(['permission:pramuka.edit|pramukas.edit'])->only(['edit', 'update']);
        $this->middleware(['permission:pramuka.delete|pramukas.delete'])->only(['destroy']);
    }

    public function index()
    {
        $pramukas = Pramuka::with('documents')->latest()->paginate(1);
        $cek_pramuka = Pramuka::count();

        return view('admin.pramuka.index', compact('pramukas', 'cek_pramuka'));
    }

    public function create()
    {
        return view('admin.pramuka.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->divisionRules());

        $pramuka = Pramuka::create($this->storeDivisionData($request, $this->folder));
        $this->storeDivisionDocuments($request, $pramuka, $this->folder);

        if ($pramuka) {
            return redirect()->route('admin.pramuka.index')->with('success', 'Data Berhasil Ditambahkan');
        }

        return redirect()->route('admin.pramuka.index')->with('error', 'Data gagal Ditambahkan');
    }

    public function edit(Pramuka $pramuka)
    {
        $pramuka->load('documents');

        return view('admin.pramuka.edit', compact('pramuka'));
    }

    public function update(Request $request, Pramuka $pramuka)
    {
        $this->validate($request, $this->divisionRules());

        $pramuka->update($this->updateDivisionData($request, $pramuka, $this->folder));
        $this->storeDivisionDocuments($request, $pramuka, $this->folder);

        if ($pramuka) {
            return redirect()->route('admin.pramuka.index')->with('success', 'Data Berhasil Diupdate');
        }

        return redirect()->route('admin.pramuka.index')->with('error', 'Data Gagal Diupdate');
    }

    public function destroy(string $id)
    {
        $pramuka = Pramuka::with('documents')->findOrFail($id);
        $this->deleteDivisionFiles($pramuka, $this->folder);
        $pramuka->delete();

        if ($pramuka) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }
}
