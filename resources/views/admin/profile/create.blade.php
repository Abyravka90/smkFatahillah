@extends('layouts.app')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Berita</h1>
            </div>

            <div class="section-body">

                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-book-open"></i> Buat Profil</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.profile.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label>GAMBAR</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">

                                @error('image')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Izin Operasional</label>
                                <input type="file" name="izin_operasional" class="form-control @error('izin_operasional') is-invalid @enderror">

                                @error('izin_operasional')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Izin Pendirian</label>
                                <input type="file" name="izin_pendirian" class="form-control @error('image') is-invalid @enderror">

                                @error('izin_pendirian')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Nama Sekolah</label>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama Sekolah" class="form-control @error('name') is-invalid @enderror">

                                @error('name')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label>KONTEN</label>
                                <textarea class="form-control content @error('content') is-invalid @enderror" name="content" placeholder="Masukkan Konten / Isi Berita" rows="10">{!! old('content') !!}</textarea>
                                @error('content')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Link Google Maps</label>
                                <textarea name="map" value="{{ old('map') }}" class="form-control @error('map') is-invalid @enderror"></textarea>
                                @error('map')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>No Telp</label>
                                <input type="tel" name="no_telp" value="{{ old('no_telp') }}" placeholder="Masukkan Nomor Telepon" class="form-control @error('no_telp') is-invalid @enderror">
                                @error('no_telp')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label>Instagram</label>
                                <input type="text" name="instagram" value="{{ old('instagram') }}" placeholder="Masukkan Link Instagram" class="form-control @error('instagram') is-invalid @enderror">
                                @error('instagram')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Youtube</label>
                                <input type="text" name="youtube" value="{{ old('youtube') }}" placeholder="Masukkan Link Youtube" class="form-control @error('youtube') is-invalid @enderror">
                                @error('youtube')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Facebook</label>
                                <input type="text" name="facebook" value="{{ old('facebook') }}" placeholder="Masukkan Link Facebook" class="form-control @error('facebook') is-invalid @enderror">
                                @error('facebook')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>TikTok</label>
                                <input type="text" name="tiktok" value="{{ old('tiktok') }}" placeholder="Masukkan Link Google Maps" class="form-control @error('tiktok') is-invalid @enderror">
                                @error('tiktok')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Twitter</label>
                                <input type="text" name="twitter" value="{{ old('twitter') }}" placeholder="Masukkan Link Twitter" class="form-control @error('twitter') is-invalid @enderror">
                                @error('twitter')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i> SIMPAN</button>
                            <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>

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