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
                <h4 class="fw-semibold mb-8">Jabatan</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted" href="/">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Jabatan</li>
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
            <button type="button" class="btn btn-info btn-rounded m-t-10 mb-2" data-bs-toggle="modal" data-bs-target="#tambahJabatan">
                <i class="fs-4 ti ti-plus"></i> Tambah Jabatan
            </button>
            @endif
        </div>
        <div class="table-responsive rounded-2 mb-4">
            <a href="/export/surat" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#searchModal" style="float: right;">
                <i class="ti ti-adjustments-alt me-1 fs-4"></i>
            </a>
            <table id="zero_config" class="table border text-nowrap customize-table mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">No.</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Nama Jabatan</h6>
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no = 1;
                    @endphp
                    @foreach($jabatan as $f)
                    <tr>
                        <td width="10%">
                            <h6 class="fs-4 fw-semibold mb-0">{{$no++}}</h6>
                        </td>
                        <td width="100%">
                            <p class="mb-0 fw-normal">{{$f->nm_jabatan}}</p>
                        </td>
                        <td>
                            <div class="dropdown dropstart">
                                <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical fs-6"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @if ($role == 2 || $role == 1)
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3 editjabatan" data-id="{{$f->id}}" href=" javascript:void(0)"><i class="fs-4 ti ti-edit"></i>Edit</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3 hapusjabatan" data-id="{{$f->id}}" id="hapusjabatan" href="javascript:void(0)"><i class="fs-4 ti ti-trash"></i>Delete</a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Start Modal Tambah Jabatan -->
<div id="tambahJabatan" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    Tambah Jabatan
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="frm_add" id="frm_add" action="simpanjabatan" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="nm_jabatan" placeholder="Nama Jabatan" required />
                            <label><i class="ti ti-file-text"></i> Nama Jabatan</label>
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
<!-- End Modal Tambah Jabatan -->

<!-- Start Modal Edit Jabatan -->
<div id="jabatanEdit" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    Edit Jabatan
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="frm_add" id="frm_add" action="updatejabatan" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Jabatan" required />
                            <label><i class="ti ti-file-text"></i> Nama Jabatan</label>
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
        //edit data
        $('body').on('click', '.editjabatan', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "editjabatan?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#id').val(data.id);
                    $('#nama').val(data.nm_jabatan);
                    $('#jabatanEdit').modal('show');
                }
            });
        });

        // Hapus jabatan
        $('body').on("click", '.hapusjabatan', function() {
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
                    location.href = 'hapusjabatan/' + idhapus;
                    swal("Deleted!", "Data berhasil dihapus.", "success");
                } else {
                    swal("Cancelled", "Your imaginary file is safe :)", "error");
                }
            });
        });

    });
</script>
@endsection