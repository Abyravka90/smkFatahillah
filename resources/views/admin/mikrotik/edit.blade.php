@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Konten Mikrotik</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-network-wired"></i> Form Edit Mikrotik</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.mikrotik.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Trainer</label>
                            <input type="text" name="trainer" value="{{ old('trainer', $mikrotik->trainer) }}" placeholder="Masukkan identitas trainer" class="form-control @error('trainer') is-invalid @enderror">
                            @error('trainer')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label>Materi</label>
                            <textarea class="form-control content @error('materi') is-invalid @enderror" name="materi" placeholder="Masukkan deskripsi materi" rows="10">{{ old('materi', $mikrotik->materi) }}</textarea>
                            @error('materi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label>Tentang Mikrotik Academy</label>
                            <textarea class="form-control" name="tentang_mikrotik_academy" placeholder="Masukkan deskripsi tentang Mikrotik Academy" rows="5">{{ old('tentang_mikrotik_academy', $mikrotik->tentang_mikrotik_academy) }}</textarea>
                            @error('tentang_mikrotik_academy')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <hr>
                        <h5>Galeri Foto Kegiatan</h5>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Foto Kegiatan 1</label>
                                    <input type="file" name="foto_kegiatan_1" class="form-control @error('foto_kegiatan_1') is-invalid @enderror">
                                    @if($mikrotik->foto_kegiatan_1) <img src="{{ asset('storage/' . $mikrotik->foto_kegiatan_1) }}" class="mt-2" style="width:100px;"> @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Foto Kegiatan 2</label>
                                    <input type="file" name="foto_kegiatan_2" class="form-control @error('foto_kegiatan_2') is-invalid @enderror">
                                    @if($mikrotik->foto_kegiatan_2) <img src="{{ asset('storage/' . $mikrotik->foto_kegiatan_2) }}" class="mt-2" style="width:100px;"> @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Foto Kegiatan 3</label>
                                    <input type="file" name="foto_kegiatan_3" class="form-control @error('foto_kegiatan_3') is-invalid @enderror">
                                    @if($mikrotik->foto_kegiatan_3) <img src="{{ asset('storage/' . $mikrotik->foto_kegiatan_3) }}" class="mt-2" style="width:100px;"> @endif
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h5>Sertifikat Siswa</h5>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Sertifikat 1</label>
                                     <input type="file" name="sertifikat_1" class="form-control @error('sertifikat_1') is-invalid @enderror">
                                     @if($mikrotik->sertifikat_1)
                                        <a href="{{ asset('storage/' . $mikrotik->sertifikat_1) }}" target="_blank" class="mt-2">Lihat Dokumen</a>
                                     @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Sertifikat 2</label>
                                     <input type="file" name="sertifikat_2" class="form-control @error('sertifikat_2') is-invalid @enderror">
                                     @if($mikrotik->sertifikat_2)
                                        <a href="{{ asset('storage/' . $mikrotik->sertifikat_2) }}" target="_blank" class="mt-2">Lihat Dokumen</a>
                                     @endif
                                </div>
                            </div>
                             <div class="col-md-4">
                                <div class="form-group">
                                    <label>Sertifikat 3</label>
                                     <input type="file" name="sertifikat_3" class="form-control @error('sertifikat_3') is-invalid @enderror">
                                     @if($mikrotik->sertifikat_3)
                                        <a href="{{ asset('storage/' . $mikrotik->sertifikat_3) }}" target="_blank" class="mt-2">Lihat Dokumen</a>
                                     @endif
                                </div>
                            </div>
                        </div>
                        
                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i> Simpan Perubahan</button>
                        <a href="{{ route('admin.mikrotik.index') }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Kembali</a>

                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

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
@stop
