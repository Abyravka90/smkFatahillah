@extends('layouts.app')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Kurikulum</h1>
    </div>

    <div class="section-body">

      <div class="card">
        <div class="card-header">
          <h4><i class="fas fa-book-open"></i> Kurikulum </h4>
          <div class="card-header-action">
            @if ($cek_kurikulum !== 1)
            <a href="{{ route('admin.kurikulum.create') }}" class="btn btn-success">
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
                <th style="width:15%;text-align:center">AKSI</th>
              </tr>
              </thead>
              <tbody>
              @forelse ($kurikulums as $no => $kurikulum)
                <tr>
                  <th style="text-align:center">
                    {{ $loop->iteration }}
                  </th>

                  <td>{{ $kurikulum->name }}</td>
                  <td>{!! $kurikulum->content !!}</td>
                  <td>
                    @if($kurikulum->image)
                      <img src="{{ $kurikulum->image }}"
                           alt="Thumbnail"
                           style="width:80px;height:80px;object-fit:cover;border-radius:8px;">
                    @else
                      <span class="text-muted">Tidak ada gambar</span>
                    @endif
                  </td>
                  <td class="text-center">
                    
                      <a href="{{ route('admin.kurikulum.edit', $kurikulum->id) }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-pencil-alt"></i>
                      </a>
                    

                    
                      <button type="button" class="btn btn-sm btn-danger"
                              onclick="confirmDelete({{ $kurikulum->id }})">
                        <i class="fa fa-trash"></i>
                      </button>
                      {{-- form delete akan disubmit setelah konfirmasi --}}
                      <form id="delete-form-{{ $kurikulum->id }}"
                            action="{{ url('/admin/kurikulum/'.$kurikulum->id) }}"
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
              {{ $kurikulums->links('vendor.pagination.bootstrap-5') }}
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>


{{-- Script: isi modal & hapus data --}}
{{-- Script: hapus data via AJAX + SweetAlert --}}
<script>
  function confirmDelete(id) {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const form  = document.getElementById('delete-form-' + id);
    // pakai URL dari form hidden-mu biar aman terhadap prefix/route group
    const url   = form ? form.getAttribute('action') : ('/admin/kurikulum/' + id);

    swal({
      title: "APAKAH KAMU YAKIN ?",
      text: "INGIN MENGHAPUS DATA INI!",
      icon: "warning",
      buttons: ['TIDAK', 'YA'],
      dangerMode: true,
    }).then(function(isConfirm) {
      if (!isConfirm) return;

      // AJAX DELETE ke controller destroy() yang sudah mengembalikan JSON
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
