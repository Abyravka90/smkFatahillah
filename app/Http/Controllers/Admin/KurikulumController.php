<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesDivisionUploads;
use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use Illuminate\Http\Request;

class KurikulumController extends Controller
{
    use HandlesDivisionUploads;

    private string $folder = 'kurikulum';

    public function __construct()
    {
        $this->middleware(['permission:kurikulum.index|kurikulums.index'])->only(['index']);
        $this->middleware(['permission:kurikulum.create|kurikulums.create'])->only(['create', 'store']);
        $this->middleware(['permission:kurikulum.edit|kurikulums.edit'])->only(['edit', 'update']);
        $this->middleware(['permission:kurikulum.delete|kurikulums.delete'])->only(['destroy']);
    }

    public function index()
    {
        $kurikulums = Kurikulum::with('documents')->latest()->paginate(1);
        $cek_kurikulum = Kurikulum::count();

        return view('admin.kurikulum.index', compact('kurikulums', 'cek_kurikulum'));
    }

    public function create()
    {
        return view('admin.kurikulum.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->divisionRules());

        $kurikulum = Kurikulum::create($this->storeDivisionData($request, $this->folder));
        $this->storeDivisionDocuments($request, $kurikulum, $this->folder);

        if ($kurikulum) {
            return redirect()->route('admin.kurikulum.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        }

        return redirect()->route('admin.kurikulum.index')->with(['error' => 'Data Gagal Ditambahkan']);
    }

    public function edit(Kurikulum $kurikulum)
    {
        $kurikulum->load('documents');

        return view('admin.kurikulum.edit', compact('kurikulum'));
    }

    public function update(Request $request, Kurikulum $kurikulum)
    {
        $this->validate($request, $this->divisionRules());

        $kurikulum->update($this->updateDivisionData($request, $kurikulum, $this->folder));
        $this->storeDivisionDocuments($request, $kurikulum, $this->folder);

        if ($kurikulum) {
            return redirect()->route('admin.kurikulum.index')->with(['success' => 'Data Berhasil Diupdate']);
        }

        return redirect()->route('admin.kurikulum.index')->with(['error' => 'Data Gagal Diupdate']);
    }

    public function destroy($id)
    {
        $kurikulum = Kurikulum::with('documents')->findOrFail($id);
        $this->deleteDivisionFiles($kurikulum, $this->folder);
        $kurikulum->delete();

        if ($kurikulum) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }
}
