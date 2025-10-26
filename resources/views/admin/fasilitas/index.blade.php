@extends('layouts.app')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Fasilitas</h1>
    </div>

    <div class="section-body">

      {{-- Alert sukses / error --}}
      @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      {{-- CARD: Upload Fasilitas (mengikuti referensi "Upload Foto") --}}
      @can('photos.create')
      <div class="card">
        <div class="card-header">
          <h4><i class="fas fa-image"></i> Upload Fasilitas</h4>
        </div>

        <div class="card-body">
          <form action="{{ route('admin.fasilitas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
              <label>GAMBAR</label>
              <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
              @error('image')
              <div class="invalid-feedback" style="display:block">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label>JUDUL</label>
              <input type="text" name="title" value="{{ old('title') }}" placeholder="Masukkan Judul Fasilitas" class="form-control @error('title') is-invalid @enderror">
              @error('title')
              <div class="invalid-feedback" style="display:block">{{ $message }}</div>
              @enderror
            </div>

            <button class="btn btn-primary mr-1 btn-submit" type="submit">
              <i class="fa fa-upload"></i> UPLOAD
            </button>
            <button class="btn btn-warning btn-reset" type="reset">
              <i class="fa fa-redo"></i> RESET
            </button>
          </form>
        </div>
      </div>
      @endcan

      {{-- CARD: Daftar Fasilitas --}}
      <div class="card">
        <div class="card-header">
          <h4><i class="fas fa-images"></i> Daftar Fasilitas</h4>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col" style="text-align:center;width:6%">NO.</th>
                  <th scope="col" style="width:180px">FOTO</th>
                  <th scope="col">JUDUL</th>
                  <th scope="col" style="width:20%;text-align:center">AKSI</th>
                </tr>
              </thead>
              <tbody>
              @forelse ($fasilitas as $no => $item)
                <tr>
                  <th scope="row" style="text-align:center">
                    {{ ++$no + ($fasilitas->currentPage()-1) * $fasilitas->perPage() }}
                  </th>
                  <td>
                    <img src="{{ $item->image }}" style="width:150px" alt="Fasilitas">
                  </td>
                  <td>{{ $item->title }}</td>
                  <td class="text-center">
                    @can('photos.edit')
                      <a href="{{ route('admin.fasilitas.edit', $item->id) }}" class="btn btn-sm btn-info">
                        <i class="fa fa-edit"></i>
                      </a>
                    @endcan
                    @can('photos.delete')
                      <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $item->id }}">
                        <i class="fa fa-trash"></i>
                      </button>
                    @endcan
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center">Belum ada data.</td>
                </tr>
              @endforelse
              </tbody>
            </table>

            <div style="text-align:center">
              {{ $fasilitas->links('vendor.pagination.bootstrap-5') }}
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

{{-- AJAX DELETE (SweetAlert) --}}
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
          url: "/admin/fasilitas/" + id,
          data: { "id": id, "_token": token },
          type: 'DELETE',
          success: function (response) {
            if (response.status === "success") {
              swal({
                title: 'BERHASIL!',
                text: 'DATA BERHASIL DIHAPUS!',
                icon: 'success',
                timer: 1000,
                buttons: false,
              }).then(function() { location.reload(); });
            } else {
              swal({
                title: 'GAGAL!',
                text: 'DATA GAGAL DIHAPUS!',
                icon: 'error',
                timer: 1000,
                buttons: false,
              }).then(function() { location.reload(); });
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
