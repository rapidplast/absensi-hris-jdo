@extends('layouts.index', [$title = 'Users'])

@section('content')
@if(Session::has('alert'))
  @if(Session::get('sweetalert')=='success')
    <div class="swalDefaultSuccess">
    </div>
  @elseif(Session::get('sweetalert')=='error')
    <div class="swalDefaultError">
    </div>
    @elseif(Session::get('sweetalert')=='warning')
    <div class="swalDefaultWarning">
    </div>
  @endif
@endif
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Users</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Users</h3>
                        <button type="button"  class="btn btn-sm btn-light float-right ml-2" style="border-radius: 50%;" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            <i class="fas fa-question"></i>
                        </button>
                    <a href="{{route('addUsers')}}" class="text-decoration-none">
                        <button type="button" class="btn btn-sm btn-success float-right">
                            Tambah Data
                        </button>
                    </a>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline collapsed" aria-describedby="example1_info">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Role </th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php

                            $no = 1;
                        ?>
                        @foreach($users as $data)

                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$data->role}}</td>
                            <td>{{$data->name}}</td>
                            <td>{{$data->email}}</td>
                            <td>{{$data->password}}</td>
                            <td>
                                <a href="{{route('editUsers', $data->id)}}" class="text-decoration-none">
                                    <button class="btn btn-warning btn-sm">Ubah</button>
                                </a>
                                <button class="btn btn-danger btn-sm" onClick="destroy('{{$data->id}}')">Hapus</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Role</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Cara Tarik Data Pegawai dari Mesin</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div id="carouselExampleControls" class="carousel slide" data-interval="0" data-ride="carousel" data-bs-pause="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <p>Pastikan mesin "ON" secara default sesuai dengan data pegawai yang ingin ditarik. Berikut tutorial cara cek apakah mesin "ON".</p>
                        <img src="{{asset('public/tutorial/TarikPegawai1.gif')}}" class="d-block w-100">
                    </div>
                    <div class="carousel-item">
                        <p>Jika tidak ada mesin "ON", klik button "OFF" pada kolom default. Ketika muncul pop up dengan text "Anda Yakin? Untuk Default Mesin Ini?", Klik "OK".</p>
                        <img src="{{asset('public/tutorial/TarikPegawai2.gif')}}" class="d-block w-100">
                    </div>
                    <div class="carousel-item">
                        <p>Setelah menyalakan mesin "ON", kembali ke halaman Data Pegawai, lalu klik button "sync pegawai". Tunggu beberapa saat, jika berhasil terdapat pop up berhasil dan halaman akan reload.</p>
                        <img src="{{asset('public/tutorial/TarikPegawai3.gif')}}" class="d-block w-100">
                    </div>
                </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Understood</button>
        </div>
    </div>
  </div>
</div>

@stop


@section('footer')
<script type="text/javascript">
    function destroy(id){
        swal({
            title: "Anda Yakin?",
            text: "Untuk menghapus data ini? Data yang terhapus TIDAK DAPAT DIKEMBALIKAN!",
            icon: 'warning',
            buttons: true,
            dangerMode: true
        })
        .then((willDelete) => {
            if(willDelete) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                        url: "{{url('Admin/Users/Delete')}}/"+id,
                        method: 'DELETE',
                        success: function (results) {
                            swal("Berhasil!", "Data Berhasil Dihapus!", "success");
                            window.location.reload();
                        },
                        error: function (results) {
                            swal("GAGAL!", "Gagal Menghapus Data!", "error");
                        }
                    });
            }else{
                swal("Data Batal Dihapus", "", "info")
            }
        })
    }
</script>
@stop