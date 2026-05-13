@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Permission</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-key"></i> Tambah Permission</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.permission.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>NAMA PERMISSION</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: posts.index"
                                class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                            SIMPAN</button>
                        <a class="btn btn-warning" href="{{ route('admin.permission.index') }}"><i class="fa fa-arrow-left"></i> KEMBALI</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@stop

