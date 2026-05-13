<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SaranaPrasarana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SaranaPrasaranaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:saranaprasarana.index'])->only(['index']);
        $this->middleware(['permission:saranaprasarana.create'])->only(['create', 'store']);
        $this->middleware(['permission:saranaprasarana.edit'])->only(['edit', 'update']);
        $this->middleware(['permission:saranaprasarana.delete'])->only(['destroy']);
    }

    public function index()
    {
        $saranaPrasaranas = SaranaPrasarana::latest()->paginate(1);
        $cek_saranaprasarana = SaranaPrasarana::count();

        return view('admin.saranaprasarana.index', compact('saranaPrasaranas', 'cek_saranaprasarana'));
    }

    public function create()
    {
        return view('admin.saranaprasarana.create');
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
            $image->storeAs('sarana_prasarana', $image->hashName(), 'public');
            $data['image'] = $image->hashName();
        }

        $saranaPrasarana = SaranaPrasarana::create($data);

        if ($saranaPrasarana) {
            return redirect()->route('admin.saranaprasarana.index')->with(['success' => 'Data Berhasil Ditambahkan']);
        }

        return redirect()->route('admin.saranaprasarana.index')->with(['error' => 'Data Gagal Ditambahkan']);
    }

    public function edit(SaranaPrasarana $saranaprasarana)
    {
        return view('admin.saranaprasarana.edit', ['saranaprasarana' => $saranaprasarana]);
    }

    public function update(Request $request, SaranaPrasarana $saranaprasarana)
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
            if ($saranaprasarana->getRawOriginal('image')) {
                Storage::disk('public')->delete('sarana_prasarana/' . basename($saranaprasarana->getRawOriginal('image')));
            }

            $image = $request->file('image');
            $image->storeAs('sarana_prasarana', $image->hashName(), 'public');
            $data['image'] = $image->hashName();
        }

        $saranaprasarana->update($data);

        if ($saranaprasarana) {
            return redirect()->route('admin.saranaprasarana.index')->with(['success' => 'Data Berhasil Diupdate']);
        }

        return redirect()->route('admin.saranaprasarana.index')->with(['error' => 'Data Gagal Diupdate']);
    }

    public function destroy(string $id)
    {
        $saranaprasarana = SaranaPrasarana::findOrFail($id);

        if ($saranaprasarana->getRawOriginal('image')) {
            Storage::disk('public')->delete('sarana_prasarana/' . basename($saranaprasarana->getRawOriginal('image')));
        }

        $saranaprasarana->delete();

        if ($saranaprasarana) {
            return response()->json([
                'status' => 'success',
            ]);
        }

        return response()->json([
            'status' => 'error',
        ]);
    }
}

