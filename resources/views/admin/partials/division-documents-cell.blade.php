@forelse($item->documents as $document)
  <a href="{{ $document->file }}" target="_blank" class="badge badge-primary mb-1 d-inline-block">{{ $document->original_name }}</a>
@empty
  <span class="text-muted">Tidak ada dokumen</span>
@endforelse
