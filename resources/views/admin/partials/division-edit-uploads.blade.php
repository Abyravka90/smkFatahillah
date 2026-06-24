<div class="form-group">
  <label>Foto Profil Saat Ini</label>
  <div class="d-flex align-items-center">
    @if($item->profile_photo)
      <img src="{{ $item->profile_photo }}" alt="Foto Profil" style="width:120px;height:120px;object-fit:cover;border-radius:50%;border:1px solid #e5e7eb;">
    @else
      <span class="text-muted">Tidak ada foto profil</span>
    @endif
  </div>
</div>

<div class="form-group">
  <label for="profile_photo">Ganti Foto Profil (opsional)</label>
  <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="form-control @error('profile_photo') is-invalid @enderror">
  @error('profile_photo')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="form-group">
  <label>Dokumen Saat Ini</label>
  @forelse($item->documents as $document)
    <div class="d-flex align-items-center justify-content-between border rounded p-2 mb-2">
      <a href="{{ $document->file }}" target="_blank">{{ $document->original_name }}</a>
      <button type="button" class="btn btn-sm btn-danger" onclick="confirmDeleteDocument({{ $document->id }})">
        <i class="fa fa-trash"></i>
      </button>
    </div>
  @empty
    <span class="text-muted">Tidak ada dokumen</span>
  @endforelse
</div>

<div class="form-group">
  <label for="documents">Tambah Dokumen (opsional)</label>
  <input type="file" id="documents" name="documents[]" multiple accept=".pdf,.doc,.docx,.xls,.xlsx" class="form-control @error('documents.*') is-invalid @enderror">
  @error('documents.*')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
  <small class="form-text text-muted">Format: PDF, DOC, DOCX, XLS, XLSX.</small>
</div>
