<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DivisionDocument;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function destroy(string $id)
    {
        $document = DivisionDocument::findOrFail($id);
        Storage::disk('public')->delete($document->folder.'/documents/'.basename($document->filename));
        $document->delete();

        if ($document) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }
}
