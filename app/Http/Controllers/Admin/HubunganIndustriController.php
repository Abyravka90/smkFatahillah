<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesDivisionUploads;
use App\Http\Controllers\Controller;
use App\Models\HubunganIndustri;
use Illuminate\Http\Request;

class HubunganIndustriController extends Controller
{
    use HandlesDivisionUploads;

    private string $folder = 'hubungan_industri';

    public function __construct()
    {
        $this->middleware(['permission:hubunganindustri.index'])->only(['index']);
        $this->middleware(['permission:hubunganindustri.create'])->only(['create', 'store']);
        $this->middleware(['permission:hubunganindustri.edit'])->only(['edit', 'update']);
        $this->middleware(['permission:hubunganindustri.delete'])->only(['destroy']);
    }

    public function index()
    {
        $hubunganIndustris = HubunganIndustri::with('documents')->latest()->paginate(1);
        $cek_hubunganindustri = HubunganIndustri::count();

        return view('admin.hubunganindustri.index', compact('hubunganIndustris', 'cek_hubunganindustri'));
    }

    public function create()
    {
        return view('admin.hubunganindustri.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->divisionRules());

        $hubunganIndustri = HubunganIndustri::create($this->storeDivisionData($request, $this->folder));
        $this->storeDivisionDocuments($request, $hubunganIndustri, $this->folder);

        if ($hubunganIndustri) {
            return redirect()->route('admin.hubunganindustri.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        }

        return redirect()->route('admin.hubunganindustri.index')->with(['error' => 'Data Gagal Ditambahkan']);
    }

    public function edit(HubunganIndustri $hubunganindustri)
    {
        $hubunganindustri->load('documents');

        return view('admin.hubunganindustri.edit', ['hubunganindustri' => $hubunganindustri]);
    }

    public function update(Request $request, HubunganIndustri $hubunganindustri)
    {
        $this->validate($request, $this->divisionRules());

        $hubunganindustri->update($this->updateDivisionData($request, $hubunganindustri, $this->folder));
        $this->storeDivisionDocuments($request, $hubunganindustri, $this->folder);

        if ($hubunganindustri) {
            return redirect()->route('admin.hubunganindustri.index')->with(['success' => 'Data Berhasil Diupdate']);
        }

        return redirect()->route('admin.hubunganindustri.index')->with(['error' => 'Data Gagal Diupdate']);
    }

    public function destroy(string $id)
    {
        $hubunganindustri = HubunganIndustri::with('documents')->findOrFail($id);
        $this->deleteDivisionFiles($hubunganindustri, $this->folder);
        $hubunganindustri->delete();

        if ($hubunganindustri) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }
}
