@extends('layouts.app')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Mikrotik Academy</h1>
    </div>

    <div class="section-body">
      <div class="card">
        <div class="card-header">
          <h4><i class="fas fa-network-wired"></i> Konten Halaman Mikrotik</h4>
          <div class="card-header-action">
            <a href="{{ route('admin.mikrotik.edit') }}" class="btn btn-primary">
              <i class="fa fa-pencil-alt"></i> Edit Konten
            </a>
          </div>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <th style="width: 25%;">Trainer</th>
                  <td>{{ $mikrotik->trainer ?? 'Belum diisi' }}</td>
                </tr>
                <tr>
                  <th>Sertifikat Trainer</th>
                  <td>
                    @if($mikrotik->sertifikat_trainer)
                      <a href="{{ asset('storage/' . $mikrotik->sertifikat_trainer) }}" target="_blank">Lihat Dokumen</a>
                    @else
                      Belum diunggah
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>Materi</th>
                  <td>{!! Str::limit($mikrotik->materi, 200) ?? 'Belum diisi' !!}</td>
                </tr>
                <tr>
                  <th>Tentang Mikrotik Academy</th>
                  <td>{{ $mikrotik->tentang_mikrotik_academy ?? 'Belum diisi' }}</td>
                </tr>
                <tr>
                  <th>Foto Kegiatan</th>
                  <td>
                      @if($mikrotik->foto_kegiatan_1) <img src="{{ asset('storage/' . $mikrotik->foto_kegiatan_1) }}" style="width:100px; margin:5px;"> @endif
                      @if($mikrotik->foto_kegiatan_2) <img src="{{ asset('storage/' . $mikrotik->foto_kegiatan_2) }}" style="width:100px; margin:5px;"> @endif
                      @if($mikrotik->foto_kegiatan_3) <img src="{{ asset('storage/' . $mikrotik->foto_kegiatan_3) }}" style="width:100px; margin:5px;"> @endif
                  </td>
                </tr>
                 <tr>
                  <th>Sertifikat</th>
                  <td>
                      @if($mikrotik->sertifikat_1) <a href="{{ asset('storage/' . $mikrotik->sertifikat_1) }}" target="_blank" style="margin-right: 10px;">Dokumen 1</a> @endif
                      @if($mikrotik->sertifikat_2) <a href="{{ asset('storage/' . $mikrotik->sertifikat_2) }}" target="_blank" style="margin-right: 10px;">Dokumen 2</a> @endif
                      @if($mikrotik->sertifikat_3) <a href="{{ asset('storage/' . $mikrotik->sertifikat_3) }}" target="_blank">Dokumen 3</a> @endif
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
