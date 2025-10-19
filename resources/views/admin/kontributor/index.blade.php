@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Berita Jurusan</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-book-open"></i> Berita Jurusan </h4>
                </div>
                <div class="card-header-action" style="padding: 1rem; text-align: right;">
                    <a href="{{ route('admin.kontributor.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Tambah Berita
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                <th scope="col">GAMBAR 1</th>
                                <th scope="col">GAMBAR 2</th>
                                <th scope="col">GAMBAR 3</th>
                                <th scope="col">JUDUL BERITA</th>
                                <th scope="col">ISI BERITA</th>
                                <th scope="col">JURUSAN</th>
                                <th scope="col" style="width: 15%;text-align: center">AKSI</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($kontributors as $no => $kontributor)
                                <tr>
                                    <th scope="row" style="text-align: center">{{$loop->iteration}}</th>
                                    <td>
                                        <img class="img-thumbnail" src="{{ asset('storage/kontributor/image_1/'.$kontributor->image_1) }}" alt="" style="max-width:300px;height:auto;display:block;">
                                    </td>
                                    <td>
                                        <img class="img-thumbnail" src="{{ asset('storage/kontributor/image_2/'.$kontributor->image_2) }}" alt="" style="max-width:300px;height:auto;display:block;">
                                    </td>

                                    <td>
                                        <img class="img-thumbnail" src="{{ asset('storage/kontributor/image_3/'.$kontributor->image_3) }}" alt="" style="max-width:300px;height:auto;display:block;">
                                    </td>
                                    <td>{{ $kontributor->title }}</td>
                                    <td>{!! $kontributor->content !!}</td>
                                    <td>{{ $kontributor->jurusan->name }}</td>
                                    <td class="text-center">
                                            <a href="{{ route('admin.kontributor.edit', $kontributor->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                            <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $kontributor->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="text-align: center">
                            {{$kontributors->links("vendor.pagination.bootstrap-5")}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<script>
    //ajax delete
    function Delete(id)
        {
            var id = id;
            var token = $("meta[name='csrf-token']").attr("content");

            swal({
                title: "APAKAH KAMU YAKIN ?",
                text: "INGIN MENGHAPUS DATA INI!",
                icon: "warning",
                buttons: [
                    'TIDAK',
                    'YA'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {


                    //ajax delete
                    jQuery.ajax({
                        url: "/admin/kontributor/"+id,
                        data:     {
                            "id": id,
                            "_token": token
                        },
                        type: 'DELETE',
                        success: function (response) {
                            if (response.status == "success") {
                                swal({
                                    title: 'BERHASIL!',
                                    text: 'DATA BERHASIL DIHAPUS!',
                                    icon: 'success',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            }else{
                                swal({
                                    title: 'GAGAL!',
                                    text: 'DATA GAGAL DIHAPUS!',
                                    icon: 'error',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            }
                        }
                    });

                } else {
                    return true;
                }
            })
        }
</script>
@stop