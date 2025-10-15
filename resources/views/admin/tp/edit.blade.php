@extends('layouts.app')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Teknik Pemesinan — Edit Konten</h1>
    </div>

    <div class="section-body">
      <div class="card">
        <div class="card-header">
          <h4><i class="fas fa-pencil-alt"></i> Edit Konten TP</h4>
          <div class="card-header-action">
            <a href="{{ route('admin.tp.index') }}" class="btn btn-light">
              <i class="fas fa-arrow-left"></i> Kembali
            </a>
          </div>
        </div>

        <div class="card-body">
          {{-- Notifikasi error global --}}
          @if ($errors->any())
            <div class="alert alert-danger">
              <strong>Terjadi kesalahan:</strong>
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('admin.tp.update', $tp->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
              <label for="name">Judul / Nama</label>
              <input type="text"
                     id="name"
                     name="name"
                     class="form-control @error('name') is-invalid @enderror"
                     value="{{ old('name', $tp->name) }}"
                     placeholder="Tulis judul/nama konten…"
                     autofocus>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="content">Isi Konten</label>
              <textarea id="content"
                        name="content"
                        rows="10"
                        class="form-control @error('content') is-invalid @enderror"
                        placeholder="Tuliskan deskripsi/isi konten…">{{ old('content', $tp->content) }}</textarea>
              @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label>Gambar Saat Ini</label>
              <div class="d-flex align-items-center">
                @if($tp->image)
                  <img src="{{ $tp->image }}"
                       alt="Gambar Lama"
                       style="width:160px;height:160px;object-fit:cover;border-radius:8px;border:1px solid #e5e7eb;">
                @else
                  <span class="text-muted">Tidak ada gambar</span>
                @endif
              </div>
            </div>

            <div class="form-group">
              <label for="image">Ganti Gambar (opsional)</label>
              <input type="file"
                     id="image"
                     name="image"
                     accept="image/*"
                     class="form-control @error('image') is-invalid @enderror">
              @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror

              <div class="mt-3">
                <img id="preview" src="#" alt="Preview Gambar Baru"
                     style="display:none;width:160px;height:160px;object-fit:cover;border-radius:8px;border:1px solid #e5e7eb;">
              </div>
              <small class="form-text text-muted">
                Biarkan kosong jika tidak ingin mengganti gambar.
              </small>
            </div>

            <div class="text-right">
              <a href="{{ route('admin.tp.index') }}" class="btn btn-secondary">Batal</a>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

{{-- TinyMCE langsung (tanpa @push) --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.6.2/tinymce.min.js"></script>
<script>
  (function () {
    tinymce.init({
      selector: "textarea#content",
      height: 420,
      menubar: false,
      plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table directionality",
        "emoticons template paste textpattern"
      ],
      toolbar:
        "undo redo | styleselect | bold italic underline | " +
        "alignleft aligncenter alignright alignjustify | " +
        "bullist numlist outdent indent | link image media | " +
        "removeformat | fullscreen preview",
      branding: false,
      relative_urls: false,
      setup: function (editor) {
        editor.on('change input keyup', function () {
          tinymce.triggerSave(); // sinkron ke <textarea>
        });
      }
    });

    // Preview gambar baru
    var input = document.getElementById('image');
    if (input) {
      input.addEventListener('change', function (e) {
        const file = e.target.files[0];
        const preview = document.getElementById('preview');
        if (file) {
          const reader = new FileReader();
          reader.onload = function (ev) {
            preview.src = ev.target.result;
            preview.style.display = 'block';
          }
          reader.readAsDataURL(file);
        } else {
          preview.src = '#';
          preview.style.display = 'none';
        }
      });
    }
  })();
</script>
@endsection
