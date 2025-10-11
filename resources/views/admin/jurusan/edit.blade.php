@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Jurusan</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-folder"></i> Form Edit Jurusan</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.jurusan.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> KEMBALI
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <div><strong>Ups!</strong> Ada kesalahan input:</div>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.jurusan.update', $jurusan->id) }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Nama Jurusan <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $jurusan->name) }}"
                                placeholder="Misal: Rekayasa Perangkat Lunak"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> UPDATE
                            </button>
                            <a href="{{ route('admin.jurusan.index') }}" class="btn btn-light ml-2">
                                BATAL
                            </a>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </section>
</div>
@endsection
