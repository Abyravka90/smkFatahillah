<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait HandlesDivisionUploads
{
    protected function divisionRules(): array
    {
        return [
            'name' => 'required',
            'content' => 'required',
            'image' => 'nullable|image',
            'profile_photo' => 'nullable|image',
            'documents.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx',
        ];
    }

    protected function storeDivisionData(Request $request, string $folder): array
    {
        $data = [
            'name' => $request->input('name'),
            'content' => $request->input('content'),
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs($folder, $image->hashName(), 'public');
            $data['image'] = $image->hashName();
        }

        if ($request->hasFile('profile_photo')) {
            $profilePhoto = $request->file('profile_photo');
            $profilePhoto->storeAs($folder.'/profile_photos', $profilePhoto->hashName(), 'public');
            $data['profile_photo'] = $profilePhoto->hashName();
        }

        return $data;
    }

    protected function updateDivisionData(Request $request, $model, string $folder): array
    {
        $data = [
            'name' => $request->input('name'),
            'content' => $request->input('content'),
        ];

        if ($request->hasFile('image')) {
            $this->deleteStoredFile($folder, $model->getRawOriginal('image'));
            $image = $request->file('image');
            $image->storeAs($folder, $image->hashName(), 'public');
            $data['image'] = $image->hashName();
        }

        if ($request->hasFile('profile_photo')) {
            $this->deleteStoredFile($folder.'/profile_photos', $model->getRawOriginal('profile_photo'));
            $profilePhoto = $request->file('profile_photo');
            $profilePhoto->storeAs($folder.'/profile_photos', $profilePhoto->hashName(), 'public');
            $data['profile_photo'] = $profilePhoto->hashName();
        }

        return $data;
    }

    protected function storeDivisionDocuments(Request $request, $model, string $folder): void
    {
        if (! $request->hasFile('documents')) {
            return;
        }

        foreach ($request->file('documents') as $document) {
            if (! $document) {
                continue;
            }

            $document->storeAs($folder.'/documents', $document->hashName(), 'public');

            $model->documents()->create([
                'folder' => $folder,
                'filename' => $document->hashName(),
                'original_name' => $document->getClientOriginalName(),
                'mime_type' => $document->getClientMimeType(),
                'size' => $document->getSize(),
            ]);
        }
    }

    protected function deleteDivisionFiles($model, string $folder): void
    {
        $this->deleteStoredFile($folder, $model->getRawOriginal('image'));
        $this->deleteStoredFile($folder.'/profile_photos', $model->getRawOriginal('profile_photo'));

        foreach ($model->documents as $document) {
            $this->deleteStoredFile($document->folder.'/documents', $document->filename);
            $document->delete();
        }
    }

    protected function deleteStoredFile(string $folder, ?string $filename): void
    {
        if ($filename) {
            Storage::disk('public')->delete($folder.'/'.basename($filename));
        }
    }
}
