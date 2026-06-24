@extends('layouts.app')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Keislaman</h1>
    </div>

    <div class="section-body">

      <div class="card">
        <div class="card-header">
          <h4><i class="fas fa-book-open"></i> Keislaman </h4>
          <div class="card-header-action">
            @if ($cek_keislaman !== 1)
            <a href="{{ route('admin.keislaman.create') }}" class="btn btn-success">
              <i class="fa fa-plus"></i> Buat Content
            </a>
            @endif
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
              <tr>
                <th style="text-align:center;width:6%">NO.</th>
                <th>Nama</th>
                <th>Content</th>
                <th>Gambar</th>
                <th>Foto Profil</th>
                <th>Dokumen</th>
                <th style="width:15%;text-align:center">AKSI</th>
              </tr>
              </thead>
              <tbody>
              @forelse ($keislamans as $no => $keislaman)
                <tr>
                  <th style="text-align:center">
                    {{ $loop->iteration }}
                  </th>

                  <td>{{ $keislaman->name }}</td>
                  <td>{!! $keislaman->content !!}</td>
                  <td>
                    @if($keislaman->image)
                      <img src="{{ $keislaman->image }}"
                           alt="Thumbnail"
                           style="width:80px;height:80px;object-fit:cover;border-radius:8px;">
                    @else
                      <span class="text-muted">Tidak ada gambar</span>
                    @endif
                  </td>
                  <td>@include('admin.partials.division-profile-photo-cell', ['item' => $keislaman])</td>
                  <td>@include('admin.partials.division-documents-cell', ['item' => $keislaman])</td>
                  <td class="text-center">
                      <a href="{{ route('admin.keislaman.edit', $keislaman->id) }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-pencil-alt"></i>
                      </a>

                      <button type="button" class="btn btn-sm btn-danger"
                              onclick="confirmDelete({{ $keislaman->id }})">
                        <i class="fa fa-trash"></i>
                      </button>
                      <form id="delete-form-{{ $keislaman->id }}"
                            action="{{ url('/admin/keislaman/'.$keislaman->id) }}"
                            method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                      </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="11" class="text-center text-muted">Belum ada data.</td>
                </tr>
              @endforelse
              </tbody>
            </table>

            <div style="text-align:center">
              {{ $keislamans->links('vendor.pagination.bootstrap-5') }}
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<script>
  function confirmDelete(id) {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const form  = document.getElementById('delete-form-' + id);
    const url   = form ? form.getAttribute('action') : ('/admin/keislaman/' + id);

    swal({
      title: "APAKAH KAMU YAKIN ?",
      text: "INGIN MENGHAPUS DATA INI!",
      icon: "warning",
      buttons: ['TIDAK', 'YA'],
      dangerMode: true,
    }).then(function(isConfirm) {
      if (!isConfirm) return;

      jQuery.ajax({
        url: url,
        type: 'DELETE',
        data: { _token: token, id: id },
        success: function (response) {
          if (response.status === "success") {
            swal({
              title: 'BERHASIL!',
              text: 'DATA BERHASIL DIHAPUS!',
              icon: 'success',
              timer: 1000,
              buttons: false,
            }).then(function () {
              location.reload();
            });
          } else {
            swal({
              title: 'GAGAL!',
              text: 'DATA GAGAL DIHAPUS!',
              icon: 'error',
              timer: 1500,
              buttons: false,
            });
          }
        },
        error: function () {
          swal({
            title: 'ERROR!',
            text: 'Terjadi kesalahan pada server.',
            icon: 'error',
            timer: 1500,
            buttons: false,
          });
        }
      });
    });
  }
</script>

@endsection

