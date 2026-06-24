<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesDivisionUploads;
use App\Http\Controllers\Controller;
use App\Models\SaranaPrasarana;
use Illuminate\Http\Request;

class SaranaPrasaranaController extends Controller
{
    use HandlesDivisionUploads;

    private string $folder = 'sarana_prasarana';

    public function __construct()
    {
        $this->middleware(['permission:saranaprasarana.index'])->only(['index']);
        $this->middleware(['permission:saranaprasarana.create'])->only(['create', 'store']);
        $this->middleware(['permission:saranaprasarana.edit'])->only(['edit', 'update']);
        $this->middleware(['permission:saranaprasarana.delete'])->only(['destroy']);
    }

    public function index()
    {
        $saranaPrasaranas = SaranaPrasarana::with('documents')->latest()->paginate(1);
        $cek_saranaprasarana = SaranaPrasarana::count();

        return view('admin.saranaprasarana.index', compact('saranaPrasaranas', 'cek_saranaprasarana'));
    }

    public function create()
    {
        return view('admin.saranaprasarana.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->divisionRules());

        $saranaPrasarana = SaranaPrasarana::create($this->storeDivisionData($request, $this->folder));
        $this->storeDivisionDocuments($request, $saranaPrasarana, $this->folder);

        if ($saranaPrasarana) {
            return redirect()->route('admin.saranaprasarana.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        }

        return redirect()->route('admin.saranaprasarana.index')->with(['error' => 'Data Gagal Ditambahkan']);
    }

    public function edit(SaranaPrasarana $saranaprasarana)
    {
        $saranaprasarana->load('documents');

        return view('admin.saranaprasarana.edit', ['saranaprasarana' => $saranaprasarana]);
    }

    public function update(Request $request, SaranaPrasarana $saranaprasarana)
    {
        $this->validate($request, $this->divisionRules());

        $saranaprasarana->update($this->updateDivisionData($request, $saranaprasarana, $this->folder));
        $this->storeDivisionDocuments($request, $saranaprasarana, $this->folder);

        if ($saranaprasarana) {
            return redirect()->route('admin.saranaprasarana.index')->with(['success' => 'Data Berhasil Diupdate']);
        }

        return redirect()->route('admin.saranaprasarana.index')->with(['error' => 'Data Gagal Diupdate']);
    }

    public function destroy(string $id)
    {
        $saranaprasarana = SaranaPrasarana::with('documents')->findOrFail($id);
        $this->deleteDivisionFiles($saranaprasarana, $this->folder);
        $saranaprasarana->delete();

        if ($saranaprasarana) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }
}
