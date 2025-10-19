@extends('layouts.app')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Edit Berita Jurusan</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('admin.kontributor.index') }}">Berita Jurusan</a></div>
        <div class="breadcrumb-item active">Edit</div>
      </div>
    </div>

    <div class="section-body">
      <div class="card">
        <div class="card-header">
          <h4><i class="fas fa-book-open"></i> Edit Berita Jurusan</h4>
          <div class="card-header-action">
            <a href="{{ route('admin.kontributor.index') }}" class="btn btn-light">
              <i class="fas fa-arrow-left"></i> Kembali
            </a>
          </div>
        </div>

        <div class="card-body">
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

          <form action="{{ route('admin.kontributor.update', $kontributor->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- GAMBAR 1 --}}
            <div class="form-group">
              <label>GAMBAR 1</label>
              @if ($kontributor->image_1)
                <div class="mb-2">
                  <img
                    src="{{ asset('storage/kontributor/image_1/'.$kontributor->image_1) }}"
                    alt="Gambar 1" class="img-thumbnail" style="max-width:300px;height:auto;">
                </div>
              @endif
              <input type="file" name="image_1" class="form-control @error('image_1') is-invalid @enderror">
              <small class="text-muted d-block">Biarkan kosong jika tidak ingin mengubah gambar 1.</small>
              @error('image_1')
                <div class="invalid-feedback" style="display:block">{{ $message }}</div>
              @enderror
            </div>

            {{-- GAMBAR 2 --}}
            <div class="form-group">
              <label>GAMBAR 2</label>
              @if ($kontributor->image_2)
                <div class="mb-2">
                  <img
                    src="{{ asset('storage/kontributor/image_2/'.$kontributor->image_2) }}"
                    alt="Gambar 2" class="img-thumbnail" style="max-width:300px;height:auto;">
                </div>
              @endif
              <input type="file" name="image_2" class="form-control @error('image_2') is-invalid @enderror">
              <small class="text-muted d-block">Biarkan kosong jika tidak ingin mengubah gambar 2.</small>
              @error('image_2')
                <div class="invalid-feedback" style="display:block">{{ $message }}</div>
              @enderror
            </div>

            {{-- GAMBAR 3 --}}
            <div class="form-group">
              <label>GAMBAR 3</label>
              @if ($kontributor->image_3)
                <div class="mb-2">
                  <img
                    src="{{ asset('storage/kontributor/image_3/'.$kontributor->image_3) }}"
                    alt="Gambar 3" class="img-thumbnail" style="max-width:300px;height:auto;">
                </div>
              @endif
              <input type="file" name="image_3" class="form-control @error('image_3') is-invalid @enderror">
              <small class="text-muted d-block">Biarkan kosong jika tidak ingin mengubah gambar 3.</small>
              @error('image_3')
                <div class="invalid-feedback" style="display:block">{{ $message }}</div>
              @enderror
            </div>

            {{-- JUDUL --}}
            <div class="form-group">
              <label>JUDUL BERITA</label>
              <input type="text" name="title"
                     value="{{ old('title', $kontributor->title) }}"
                     placeholder="Masukkan Judul Berita"
                     class="form-control @error('title') is-invalid @enderror">
              @error('title')
                <div class="invalid-feedback" style="display:block">{{ $message }}</div>
              @enderror
            </div>

            {{-- JURUSAN --}}
            <div class="form-group">
              <label>Jurusan</label>
              <select class="form-control select-category @error('jurusan_id') is-invalid @enderror" name="jurusan_id">
                <option value="">-- PILIH JURUSAN --</option>
                @foreach ($jurusans as $jurusan)
                  <option value="{{ $jurusan->id }}"
                    {{ (string) old('jurusan_id', $kontributor->jurusan_id) === (string) $jurusan->id ? 'selected' : '' }}>
                    {{ $jurusan->name }}
                  </option>
                @endforeach
              </select>
              @error('jurusan_id')
                <div class="invalid-feedback" style="display:block">{{ $message }}</div>
              @enderror
            </div>

            {{-- KONTEN --}}
            <div class="form-group">
              <label>KONTEN</label>
              <textarea class="form-control content @error('content') is-invalid @enderror"
                        name="content" rows="10"
                        placeholder="Masukkan Konten / Isi Berita">{!! old('content', $kontributor->content) !!}</textarea>
              @error('content')
                <div class="invalid-feedback" style="display:block">{{ $message }}</div>
              @enderror
            </div>

            <button class="btn btn-primary mr-1 btn-submit" type="submit">
              <i class="fa fa-save"></i> UPDATE
            </button>
            <a href="{{ route('admin.kontributor.index') }}" class="btn btn-light">BATAL</a>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

{{-- TinyMCE --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.6.2/tinymce.min.js"></script>
<script>
  var editor_config = {
    selector: "textarea.content",
    plugins: [
      "advlist autolink lists link image charmap print preview hr anchor pagebreak",
      "searchreplace wordcount visualblocks visualchars code fullscreen",
      "insertdatetime media nonbreaking save table contextmenu directionality",
      "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    relative_urls: false,
  };
  tinymce.init(editor_config);
</script>
@endsection
