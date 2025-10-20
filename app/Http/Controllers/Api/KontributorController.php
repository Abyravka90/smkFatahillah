<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kontributor;
use Illuminate\Http\Request;

class KontributorController extends Controller
{
    //
    public function show($jurusan_id){
    $kontributors = Kontributor::where('jurusan_id', $jurusan_id)->latest()->paginate(5);

    if ($kontributors->count() > 0) {
        return response()->json([
            "response" => ["status" => 200, "message" => "List Data Kontributor"],
            "data" => $kontributors
        ], 200);
    }

    return response()->json([
        "response" => ["status" => 404, "message" => "Data tidak ditemukan"],
        "data" => null
    ], 404);
    }
// SHOW detail by slug ATAU id
    public function detail($slugOrId)
    {
        $kontributor = Kontributor::when(is_numeric($slugOrId), function ($q) use ($slugOrId) {
                $q->where('id', $slugOrId);
            }, function ($q) use ($slugOrId) {
                $q->where('slug', $slugOrId);
            })
            ->first();

        if (!$kontributor) {
            return response()->json([
                "response" => ["status" => 404, "message" => "Data tidak ditemukan"],
                "data"     => null
            ], 404);
        }

        // Format detail + URL gambar publik
        $data = [
            'id'          => $kontributor->id,
            'title'       => $kontributor->title,
            'content'     => $kontributor->content,
            'jurusan_id'  => $kontributor->jurusan_id,
            'slug'        => $kontributor->slug ?? null,
            'image_1'     => $kontributor->image_1,
            'image_2'     => $kontributor->image_2,
            'image_3'     => $kontributor->image_3,
            'image_1_url' => $this->imageUrl($kontributor->image_1, 'image_1'),
            'image_2_url' => $this->imageUrl($kontributor->image_2, 'image_2'),
            'image_3_url' => $this->imageUrl($kontributor->image_3, 'image_3'),
            'created_at'  => $kontributor->created_at,
            'updated_at'  => $kontributor->updated_at,
        ];

        return response()->json([
            "response" => ["status" => 200, "message" => "Detail Kontributor"],
            "data"     => $data
        ], 200);
    }

    // Helper bikin URL publik sesuai struktur storage/kontributor/image_1|2|3/<filename>
    private function imageUrl(?string $filename, string $field = 'image_1'): ?string
    {
        if (!$filename) return null;

        // Jika kamu terkadang menyimpan path penuh (storage/..., kontributor/...), hormati itu:
        if (str_starts_with($filename, 'storage/')) {
            return asset($filename);
        }
        if (str_contains($filename, '/')) {
            return asset('storage/' . ltrim($filename, '/'));
        }

        // Umum: hanya nama file
        return asset("storage/kontributor/{$field}/{$filename}");
    }
}


