@extends('layouts.app')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Video</h1>
            </div>

            <div class="section-body">

                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-video"></i> Tambah Video</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.video.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label>JUDUL VIDEO</label>
                                <input type="text" name="title" value="{{ old('title') }}" placeholder="Masukkan Judul Video" class="form-control @error('title') is-invalid @enderror">

                                @error('title')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>EMBED YOUTUBE</label>
                                <textarea name="embbed" placeholder="Masukkan Embbed YouTube" class="form-control @error('embbed') is-invalid @enderror">{{ old('embbed') }}</textarea>
                                @error('embbed')
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
@stop