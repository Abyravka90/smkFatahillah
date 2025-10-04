@extends('layouts.app')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Profile</h1>
    </div>

    <div class="section-body">

      <div class="card">
        <div class="card-header">
          <h4><i class="fas fa-book-open"></i> Profile Sekolah</h4>
          @can('posts.create')
          <div class="card-header-action">
            @if ($cek_profile !== 1)
            <a href="{{ route('admin.profile.create') }}" class="btn btn-success">
              <i class="fa fa-plus"></i> Buat Profile
            </a>
            @endif
          </div>
          @endcan
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
              <tr>
                <th style="text-align:center;width:6%">NO.</th>
                <th>Nama Sekolah</th>
                <th>Gambar</th>
                <th>Isi</th>
                <th>Map</th>
                <th>No Telp</th>
                <th>Instagram</th>
                <th>Facebook</th>
                <th>TikTok</th>
                <th>Twitter</th>
                <th style="width:15%;text-align:center">AKSI</th>
              </tr>
              </thead>
              <tbody>
              @forelse ($profiles as $no => $profile)
                <tr>
                  <th style="text-align:center">
                    {{ ++$no + ($profiles->currentPage()-1) * $profiles->perPage() }}
                  </th>

                  <td>{{ $profile->name }}</td>

                  <td>
                    @if($profile->image)
                      <img src="{{ $profile->image }}"
                           alt="Thumbnail"
                           style="width:80px;height:80px;object-fit:cover;border-radius:8px;">
                    @else
                      <span class="text-muted">Tidak ada gambar</span>
                    @endif
                  </td>

                  <td>
                    <span>{{ \Illuminate\Support\Str::limit(strip_tags($profile->content), 150, '…') }}</span>
                    <a href="javascript:void(0)"
                       data-toggle="modal"
                       data-target="#contentModal"
                       data-id="{{ $profile->id }}">Lihat</a>
                    {{-- konten lengkap disimpan tersembunyi sebagai sumber modal --}}
                    <div id="content-full-{{ $profile->id }}" class="d-none">
                      {!! $profile->content !!}
                    </div>
                  </td>

                  <td>
                    @if($profile->map)
                      <div style="width:200px;height:150px;overflow:hidden;border-radius:8px;">
                        {!! $profile->map !!}
                      </div>
                    @else
                      <span class="text-muted">Tidak ada map</span>
                    @endif
                  </td>

                  <td>{{ $profile->no_telp ?? '-' }}</td>
                  <td>
                    @if($profile->instagram)
                      <a href="{{ $profile->instagram }}" target="_blank" rel="noopener">Instagram</a>
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td>
                    @if($profile->facebook)
                      <a href="{{ $profile->facebook }}" target="_blank" rel="noopener">Facebook</a>
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td>
                    @if($profile->tiktok)
                      <a href="{{ $profile->tiktok }}" target="_blank" rel="noopener">TikTok</a>
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td>
                    @if($profile->twitter)
                      <a href="{{ $profile->twitter }}" target="_blank" rel="noopener">Twitter/X</a>
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>

                  <td class="text-center">
                    @can('posts.edit')
                      <a href="{{ route('admin.profile.edit', $profile->id) }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-pencil-alt"></i>
                      </a>
                    @endcan

                    @can('posts.delete')
                      <button type="button" class="btn btn-sm btn-danger"
                              onclick="confirmDelete({{ $profile->id }})">
                        <i class="fa fa-trash"></i>
                      </button>
                      {{-- form delete akan disubmit setelah konfirmasi --}}
                      <form id="delete-form-{{ $profile->id }}"
                            action="{{ url('/admin/profile/'.$profile->id) }}"
                            method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                      </form>
                    @endcan
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
              {{ $profiles->links('vendor.pagination.bootstrap-5') }}
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

{{-- Modal reusable: TARUH DI LUAR TABEL/CARD --}}
<div class="modal fade" id="contentModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Konten Lengkap</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"><em>Memuat…</em></div>
    </div>
  </div>
</div>

{{-- Perbaiki kemungkinan konflik z-index tema --}}
<style>
  .modal-backdrop { z-index: 1040 !important; }
  .modal         { z-index: 1050 !important; }
</style>

{{-- Script: isi modal & hapus data --}}
<script>
  // isi modal saat dibuka
  $('#contentModal').on('show.bs.modal', function (e) {
    var trigger = $(e.relatedTarget);
    var id = trigger.data('id');
    var html = $('#content-full-' + id).html() || '<em>Tidak ada konten</em>';
    $(this).find('.modal-body').html(html);
  });

  // bersihkan backdrop kalau nyangkut
  $('#contentModal').on('hidden.bs.modal', function () {
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
  });

  // konfirmasi hapus → submit form DELETE (controller kamu redirect)
  function confirmDelete(id) {
    swal({
      title: "APAKAH KAMU YAKIN ?",
      text: "INGIN MENGHAPUS DATA INI!",
      icon: "warning",
      buttons: ['TIDAK', 'YA'],
      dangerMode: true,
    }).then(function(isConfirm) {
      if (isConfirm) {
        document.getElementById('delete-form-' + id).submit();
      }
    });
  }
</script>
@endsection
