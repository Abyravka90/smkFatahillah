@extends('layouts.app')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>SPMB</h1>
    </div>

    <div class="section-body">

      {{-- Alerts --}}
      @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
      @if (session('error'))   <div class="alert alert-danger">{{ session('error') }}</div>   @endif

      {{-- FORM: Upload SPMB (single-page create) --}}
      @can('photos.create')
      <div class="card">
        <div class="card-header">
          <h4><i class="fas fa-file-upload"></i> Upload SPMB</h4>
        </div>
        <div class="card-body">
          <form action="{{ route('admin.spmb.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
              <label>GAMBAR (opsional)</label>
              <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
              @error('image') <div class="invalid-feedback" style="display:block">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
              <label>FILE PDF (opsional)</label>
              <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept="application/pdf">
              @error('file') <div class="invalid-feedback" style="display:block">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
              <label>LINK (opsional)</label>
              <input type="url" name="link" value="{{ old('link') }}" placeholder="https://..." class="form-control @error('link') is-invalid @enderror">
              @error('link') <div class="invalid-feedback" style="display:block">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
              <label>JUDUL</label>
              <input type="text" name="title" value="{{ old('title') }}" placeholder="Masukkan Judul" class="form-control @error('title') is-invalid @enderror">
              @error('title') <div class="invalid-feedback" style="display:block">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
              <label>ISI/KONTEN (opsional)</label>
              <textarea name="content" rows="4" class="form-control @error('content') is-invalid @enderror" placeholder="Tulis ringkasan atau konten SPMB">{{ old('content') }}</textarea>
              @error('content') <div class="invalid-feedback" style="display:block">{{ $message }}</div> @enderror
            </div>

            <button class="btn btn-primary mr-1" type="submit"><i class="fa fa-upload"></i> UPLOAD</button>
            <button class="btn btn-warning" type="reset"><i class="fa fa-redo"></i> RESET</button>
          </form>
        </div>
      </div>
      @endcan

      {{-- LIST: SPMB --}}
      <div class="card">
        <div class="card-header">
          <h4><i class="fas fa-list"></i> Daftar SPMB</h4>
          {{-- tombol Tambah (Halaman) DIHILANGKAN sesuai permintaan --}}
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="text-align:center;width:6%">NO.</th>
                  <th style="width:180px">GAMBAR</th>
                  <th>JUDUL & RINGKASAN</th>
                  <th style="width:18%">LINK</th>
                  <th style="width:14%">FILE PDF</th>
                  <th style="width:16%;text-align:center">AKSI</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($spmbs as $no => $item)
                  <tr>
                    <th style="text-align:center">
                      {{ ++$no + ($spmbs->currentPage()-1) * $spmbs->perPage() }}
                    </th>
                    <td>
                      @php
                        // IMAGE via accessor: $item->image -> /storage/spmb/image/<filename> (atau null)
                        $imgSrc = $item->image ?: 'https://via.placeholder.com/150?text=No+Image';
                      @endphp
                      <img src="{{ $imgSrc }}" style="width:150px" alt="SPMB Image">
                    </td>
                    <td>
                      <strong>{{ $item->title }}</strong>
                      @php
                        $excerpt = \Illuminate\Support\Str::limit(strip_tags((string) $item->content), 120);
                      @endphp
                      @if ($excerpt)
                        <div class="text-muted small mt-1">{{ $excerpt }}</div>
                      @endif
                    </td>
                    <td>
                      @if (!empty($item->link))
                        <a href="{{ $item->link }}" target="_blank" rel="noopener">Buka Link <i class="fas fa-external-link-alt"></i></a>
                      @else
                        <span class="text-muted">—</span>
                      @endif
                    </td>
                    <td>
                      @php
                        // FILE tanpa accessor → disimpan di storage/app/public/spmb/file/<filename>
                        $fileUrl = !empty($item->file) ? asset('storage/spmb/file/' . basename($item->file)) : null;
                      @endphp
                      @if ($fileUrl)
                        <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                          <i class="fa fa-file-pdf"></i> Lihat PDF
                        </a>
                      @else
                        <span class="text-muted">—</span>
                      @endif
                    </td>
                    <td class="text-center">
                      
                        <a href="{{ route('admin.spmb.edit', $item->id) }}" class="btn btn-sm btn-info">
                          <i class="fa fa-edit"></i>
                        </a>
                      
                      @can('photos.delete')
                        <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $item->id }}">
                          <i class="fa fa-trash"></i>
                        </button>
                      @endcan
                    </td>
                  </tr>
                @empty
                  <tr><td colspan="6" class="text-center">Belum ada data.</td></tr>
                @endforelse
              </tbody>
            </table>

            <div style="text-align:center">
              {{ $spmbs->links('vendor.pagination.bootstrap-5') }}
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

{{-- AJAX DELETE --}}
<script>
  function Delete(id) {
    var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    swal({
      title: "APAKAH KAMU YAKIN ?",
      text: "INGIN MENGHAPUS DATA INI!",
      icon: "warning",
      buttons: ['TIDAK','YA'],
      dangerMode: true,
    }).then(function(isConfirm) {
      if (isConfirm) {
        jQuery.ajax({
          url: "/admin/spmb/" + id,
          data: { "id": id, "_token": token },
          type: 'DELETE',
          success: function (response) {
            if (response.status === "success") {
              swal({ title: 'BERHASIL!', text: 'DATA BERHASIL DIHAPUS!', icon: 'success', timer: 1000, buttons: false })
                .then(function() { location.reload(); });
            } else {
              swal({ title: 'GAGAL!', text: 'DATA GAGAL DIHAPUS!', icon: 'error', timer: 1000, buttons: false })
                .then(function() { location.reload(); });
            }
          }
        });
      } else {
        return true;
      }
    });
  }
</script>
@endsection
