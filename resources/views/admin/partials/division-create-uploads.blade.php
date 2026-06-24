<div class="form-group">
  <label for="profile_photo">Foto Profil (opsional)</label>
  <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="form-control @error('profile_photo') is-invalid @enderror">
  @error('profile_photo')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="form-group">
  <label for="documents">Dokumen (opsional)</label>
  <input type="file" id="documents" name="documents[]" multiple accept=".pdf,.doc,.docx,.xls,.xlsx" class="form-control @error('documents.*') is-invalid @enderror">
  @error('documents.*')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
  <small class="form-text text-muted">Format: PDF, DOC, DOCX, XLS, XLSX.</small>
</div>
