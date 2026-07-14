<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMikrotikRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Izinkan semua user terotentikasi untuk melakukan request ini
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'trainer'                  => 'nullable|string',
            'materi'                   => 'nullable|string',
            'tentang_mikrotik_academy' => 'nullable|string',
            'foto_kegiatan_1'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_kegiatan_2'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_kegiatan_3'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sertifikat_1'             => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:5120',
            'sertifikat_2'             => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:5120',
            'sertifikat_3'             => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:5120',
        ];
    }
}
