@extends('layouts.app')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Sarana dan Prasarana</h1>
    </div>

    <div class="section-body">

      <div class="card">
        <div class="card-header">
          <h4><i class="fas fa-book-open"></i> Sarana dan Prasarana </h4>
          <div class="card-header-action">
            @if ($cek_saranaprasarana !== 1)
            <a href="{{ route('admin.saranaprasarana.create') }}" class="btn btn-success">
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
              @forelse ($saranaPrasaranas as $no => $saranaprasarana)
                <tr>
                  <th style="text-align:center">
                    {{ $loop->iteration }}
                  </th>

                  <td>{{ $saranaprasarana->name }}</td>
                  <td>{!! $saranaprasarana->content !!}</td>
                  <td>
                    @if($saranaprasarana->image)
                      <img src="{{ $saranaprasarana->image }}"
                           alt="Thumbnail"
                           style="width:80px;height:80px;object-fit:cover;border-radius:8px;">
                    @else
                      <span class="text-muted">Tidak ada gambar</span>
                    @endif
                  </td>
                  <td>@include('admin.partials.division-profile-photo-cell', ['item' => $saranaprasarana])</td>
                  <td>@include('admin.partials.division-documents-cell', ['item' => $saranaprasarana])</td>
                  <td class="text-center">
                      <a href="{{ route('admin.saranaprasarana.edit', $saranaprasarana->id) }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-pencil-alt"></i>
                      </a>

                      <button type="button" class="btn btn-sm btn-danger"
                              onclick="confirmDelete({{ $saranaprasarana->id }})">
                        <i class="fa fa-trash"></i>
                      </button>
                      <form id="delete-form-{{ $saranaprasarana->id }}"
                            action="{{ url('/admin/saranaprasarana/'.$saranaprasarana->id) }}"
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
              {{ $saranaPrasaranas->links('vendor.pagination.bootstrap-5') }}
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
    const url   = form ? form.getAttribute('action') : ('/admin/saranaprasarana/' + id);

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

