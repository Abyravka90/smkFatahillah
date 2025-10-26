@extends('layouts.app')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Edit SPMB</h1>
    </div>

    <div class="section-body">
      {{-- Alerts --}}
      @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
      @if (session('error'))   <div class="alert alert-danger">{{ session('error') }}</div>   @endif

      <div class="card">
        <div class="card-header">
          <h4><i class="fas fa-edit"></i> Form Edit SPMB</h4>
          <div class="card-header-action">
            <a href="{{ route('admin.spmb.index') }}" class="btn btn-light">
              <i class="fas fa-arrow-left"></i> Kembali
            </a>
          </div>
        </div>

        <div class="card-body">
          <form action="{{ route('admin.spmb.update', $spmb->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
              <label>JUDUL</label>
              <input type="text" name="title" value="{{ old('title', $spmb->title) }}" class="form-control @error('title') is-invalid @enderror">
              @error('title') <div class="invalid-feedback" style="display:block">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
              <label>LINK (opsional)</label>
              <input type="url" name="link" value="{{ old('link', $spmb->link) }}" class="form-control @error('link') is-invalid @enderror">
              @error('link') <div class="invalid-feedback" style="display:block">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
              <label>ISI/KONTEN (opsional)</label>
              <textarea name="content" rows="5" class="form-control @error('content') is-invalid @enderror">{{ old('content', $spmb->content) }}</textarea>
              @error('content') <div class="invalid-feedback" style="display:block">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
              <label>GAMBAR (opsional — upload untuk mengganti)</label>
              <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
              @error('image') <div class="invalid-feedback" style="display:block">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
              <label>PREVIEW GAMBAR SAAT INI</label><br>
              @php
                $imgSrc = $spmb->image ?: 'https://via.placeholder.com/250x150?text=No+Image';
              @endphp
              <img src="{{ $imgSrc }}" alt="Current Image" style="max-width:250px;">
            </div>

            <div class="form-group">
              <label>FILE PDF (opsional — upload untuk mengganti)</label>
              <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept="application/pdf">
              @error('file') <div class="invalid-feedback" style="display:block">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
              <label>FILE PDF SAAT INI</label><br>
              @php
                $fileUrl = !empty($spmb->file) ? asset('storage/spmb/file/' . basename($spmb->file)) : null;
              @endphp
              @if ($fileUrl)
                <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                  <i class="fa fa-file-pdf"></i> Lihat PDF
                </a>
              @else
                <span class="text-muted">Tidak ada file.</span>
              @endif
            </div>

            <div class="mt-4">
              
              <button class="btn btn-primary mr-1" type="submit">
                <i class="fa fa-save"></i> SIMPAN PERUBAHAN
              </button>
              
              <a href="{{ route('admin.spmb.index') }}" class="btn btn-secondary">BATAL</a>
            </div>
          </form>
        </div>
      </div>

    </div>
  </section>
</div>
@endsection
