@extends('master')
@section('konten')
<?php

use App\Models\Disposisi;
use Illuminate\Support\Facades\Auth;

$iduser = Auth::user()->id;
$role = Auth::user()->role;
$id_pegawai = $iduser;
$suratt = Disposisi::find($id_pegawai);
$fileName = Route::current()->getName();
?>
<div class="card bg-light-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Barang</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted" href="/">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Barang</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="card w-100 position-relative overflow-hidden">
    <div class="card-body p-4">
        @if(Session::has('sukses'))
        <div class="alert alert-success alertku text-center">
            {{ Session::get('sukses') }}
        </div>
        @endif
        <div class="d-flex justify-content-start">
            @if ($role == 1 || $role == 2)
            <button type="button" class="btn btn-info btn-rounded m-t-10 mb-2" data-bs-toggle="modal" data-bs-target="#tambahBarang">
                <i class="fs-4 ti ti-plus"></i> Tambah Barang
            </button>
            @endif
        </div>
        <div class="table-responsive">
            <a href="/export/surat" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#searchModal" style="float: right;">
                <i class="ti ti-adjustments-alt me-1 fs-4"></i>
            </a>
            <table id="zero_config" class="table border text-nowrap customize-table mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>
                            <center>
                                <h6 class="fs-4 fw-semibold mb-0">No.</h6>
                            </center>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Nama</h6>
                        </th>
                        <th>
                            <center>
                                <h6 class="fs-4 fw-semibold mb-0">Image</h6>
                            </center>
                        </th>
                        <th>
                            <center>
                                <h6 class="fs-4 fw-semibold mb-0">Jumlah</h6>
                            </center>
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no = 1;
                    @endphp
                    @foreach($barang as $f)
                    <tr>
                        <td width="5%">
                            <center>
                                <h6 class="fs-4 fw-semibold mb-0">{{$no++}}</h6>
                            </center>
                        </td>
                        <td width="50%">
                            <p class="mb-0 fw-normal">{{$f->nama_barang}}</p>
                        </td>
                        <td width="15%">
                            <center>
                                <p class="mb-0 fw-normal"><a href="javascript:void(0)" data-id="{{$f->id}}" class="btn btn-default gambar"> Klik Gambar</a></p>
                            </center>
                        </td>
                        <td width="10%">
                            <center>
                                <p class="mb-0 fw-normal">{{$f->qty}}</p>
                            </center>
                        </td>
                        <td width="5%">
                            <center>
                                <div class="dropdown dropstart">
                                    <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical fs-6"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-3 edit{{$fileName}}" data-id="{{$f->id}}" href=" javascript:void(0)"><i class="fs-4 ti ti-edit"></i>Edit</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-3 hapusbarang" data-id="{{$f->id}}" id="hapusbarang" href="javascript:void(0)"><i class="fs-4 ti ti-trash"></i>Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </center>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Start Modal Gambar -->
<div class="modal fade" id="modalIMG" tabindex="-1" role="dialog" aria-labelledby="addnotesmodalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-header bg-primary">
                <h6 class="modal-title text-white">Gambar</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                    <img src="" alt="" id="gambarTampil" style="height: 300px; width: 300px;">
                </center>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Gambar -->

<!-- Start Modal Tambah Barang -->
<div id="tambahBarang" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    Tambah Barang
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="frm_add" id="frm_add" action="simpanbarang" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="nama" placeholder="Nama Barang" required />
                            <label><i class="ti ti-file-text"></i> Nama Barang</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="file" class="form-control" name="file" required>
                            <label><i class="ti ti-file-text"></i> Gambar</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" name="qty" placeholder="qty" required />
                            <label><i class="ti ti-file-text"></i> Jumlah</label>
                        </div>
                        <input type="hidden" class="form-control" name="created" id="created" aria-describedby="created" value="{{ Auth::user()->name }}">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">
                            <i class="ti ti-device-floppy me-1 fs-4"></i> Simpan
                        </button>
                        <button type="button" class="btn btn-default waves-effect" data-bs-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Tambah Barang -->

<!-- Start Modal Edit Barang -->
<div id="barangEdit" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    Edit Barang
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="frm_add" id="frm_add" action="updatebarang" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Barang" required />
                            <label><i class="ti ti-file-text"></i> Nama Barang</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="file" class="form-control" name="file">
                            <label><i class="ti ti-file-text"></i> Gambar</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" name="qty" id="qty" placeholder="qty" required />
                            <label><i class="ti ti-file-text"></i> Jumlah</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">
                            <i class="ti ti-device-floppy me-1 fs-4"></i> Simpan
                        </button>
                        <button type="button" class="btn btn-default waves-effect" data-bs-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Edit Divisi -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Gambar
        $('body').on('click', '.gambar', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "gambarbarang?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {

                    $('#gambarTampil').attr('src', 'img/' + data.image);
                    $('#modalIMG').modal('show');
                }

            });
        });

        //edit data
        $('body').on('click', '.editbarang', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "editbarang?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#id').val(data.id);
                    $('#nama').val(data.nama_barang);
                    $('#qty').val(data.qty);
                    $('#barangEdit').modal('show');
                }

            });
        });

        // Hapus
        $('body').on("click", '.hapusbarang', function() {
            var idhapus = $(this).attr('data-id');
            swal({
                title: "Apakah anda yakin?",
                text: "Data yang sudah di hapus tidak dapat dikembalikan!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No cancel !",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm) {
                if (isConfirm) {
                    location.href = 'hapusbarang/' + idhapus;
                    swal("Deleted!", "Data berhasil dihapus.", "success");
                } else {
                    swal("Cancelled", "Your imaginary file is safe :)", "error");
                }
            });
        });

    });
</script>
@endsection