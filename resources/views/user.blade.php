@extends('master')
@section('konten')
<?php

use App\Models\Disposisi;
use Illuminate\Support\Facades\Auth;

$iduser = Auth::user()->id;
$nama = Auth::user()->name;
$role = Auth::user()->role;
$id_pegawai = $iduser;
$suratt = Disposisi::find($id_pegawai);
$fileName = Route::current()->getName();
?>
<div class="card bg-light-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Pegawai</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted" href="/">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Pegawai</li>
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
            <button type="button" class="btn btn-info btn-rounded m-t-10 mb-2" data-bs-toggle="modal" data-bs-target="#tambahPegawai">
                <i class="fs-4 ti ti-plus"></i> Tambah Pegawai
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
                            <h6 class="fs-4 fw-semibold mb-0">No</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">NIP</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Username</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Nama</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Divisi</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Jabatan</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">No. Telp</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Role</h6>
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no = 1;
                    @endphp
                    @foreach($user as $user)
                    <tr>
                        <td>
                            <h6 class="fs-4 fw-semibold mb-0">{{$no++}}</h6>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$user->nip}}</p>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$user->username}}</p>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$user->name}}</p>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$user->divisi->nama_divisi ?? 'SuperAdmin'}}</p>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$user->jabatan->nm_jabatan ?? 'SuperAdmin'}}</p>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$user->no_telp}}</p>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">
                                @if ($user->role == 1)
                                Admin
                                @elseif ($user->role == 2)
                                Manager
                                @elseif ($user->role == 3)
                                SPV
                                @elseif ($user->role == 4)
                                Staff
                                @elseif ($user->role == 5)
                                Satpam
                                @endif
                            </p>
                        </td>
                        <td>
                            <div class="dropdown dropstart">
                                <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical fs-6"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @if ($role == 2 || $role == 1)
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3 pegawaiEdit" data-id="{{$user->id}}" href=" javascript:void(0)"><i class="fs-4 ti ti-edit"></i>Edit</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3 hapus" data-id="{{$user->id}}" id="hapus" href="javascript:void(0)"><i class="fs-4 ti ti-trash"></i>Delete</a>
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

<!-- Start Modal Tambah Transaksi -->
<div id="tambahPegawai" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    Tambah Pegawai
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="frm_add" id="frm_add" action="simpan_user" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <input type="number" name="nip" placeholder="NIP" class="form-control" required>
                            <label><i class="ti ti-file-text"></i> NIP</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="name" placeholder="No. Transaksi" required />
                            <label><i class="ti ti-file-text"></i> Nama</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="username" placeholder="No. Transaksi" required />
                            <label><i class="ti ti-file-text"></i> Username</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="password" placeholder="No. Transaksi" required />
                            <label><i class="ti ti-file-text"></i> Password</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="No. Transaksi" required>
                            <label><i class="ti ti-file-text"></i>Confirm Password</label>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select col-12" name="divisi" required>
                            <option value="">-- Pilih Divisi --</option>
                            @foreach($divisi as $p)
                            <option value="{{$p->id}}"> {{$p->nama_divisi}} </option>
                            @endforeach
                        </select>
                        <label><i class="ti ti-file-text"></i> Divisi</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select col-12" name="jabatan" required>
                            <option value="">-- Pilih Jabatan --</option>
                            @foreach($jabatan as $p)
                            <option value="{{$p->id}}"> {{$p->nm_jabatan}} </option>
                            @endforeach
                        </select>
                        <label><i class="ti ti-file-text"></i> Jabatan</label>
                    </div>
                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" name="email" placeholder="No. Transaksi" required />
                            <label><i class="ti ti-file-text"></i> Email</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" name="no_telp" placeholder="No. Transaksi" required />
                            <label><i class="ti ti-file-text"></i> No. Telp</label>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select col-12" name="role" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="1">Admin</option>
                            <option value="2">Manager</option>
                            <option value="3">SPV</option>
                            <option value="4">Staf</option>
                            <option value="5">Satpam</option>
                        </select>
                        <label><i class="ti ti-file-text"></i> Role</label>
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
<!-- End Modal Tambah Transaksi -->

<!-- Start Modal Edit Transaksi -->
<div id="editPegawai" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    Tambah Pegawai
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="frm_add" id="frm_add" action="update_user" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <input type="number" name="nip" id="nip" placeholder="NIP" class="form-control" required>
                            <label><i class="ti ti-file-text"></i> NIP</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="name" id="name" placeholder="No. Transaksi" required />
                            <label><i class="ti ti-file-text"></i> Nama</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="username" id="username" placeholder="No. Transaksi" required />
                            <label><i class="ti ti-file-text"></i> Username</label>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select col-12" name="divisi" id="divisi" required>
                            <option value="">-- Pilih Divisi --</option>
                            @foreach($divisi as $p)
                            <option value="{{$p->id}}"> {{$p->nama_divisi}} </option>
                            @endforeach
                        </select>
                        <label><i class="ti ti-file-text"></i> Divisi</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select col-12" name="jabatan" id="jabatan" required>
                            <option value="">-- Pilih Jabatan --</option>
                            @foreach($jabatan as $p)
                            <option value="{{$p->id}}"> {{$p->nm_jabatan}} </option>
                            @endforeach
                        </select>
                        <label><i class="ti ti-file-text"></i> Jabatan</label>
                    </div>
                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" name="email" id="email" placeholder="No. Transaksi" required />
                            <label><i class="ti ti-file-text"></i> Email</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" name="no_telp" id="no_telp" placeholder="No. Transaksi" required />
                            <label><i class="ti ti-file-text"></i> No. Telp</label>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select col-12" name="role" id="role" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="1">Admin</option>
                            <option value="2">Manager</option>
                            <option value="3">SPV</option>
                            <option value="4">Staf</option>
                            <option value="5">Satpam</option>
                        </select>
                        <label><i class="ti ti-file-text"></i> Role</label>
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
<!-- End Modal Edit Transaksi -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Edit Pegawai    
        $('body').on('click', '.pegawaiEdit', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{route('edit_user')}}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#id').val(data.id);
                    $('#nip').val(data.nip);
                    $('#username').val(data.username);
                    $('#name').val(data.name);
                    $('#divisi').val(data.id_divisi);
                    $('#jabatan').val(data.id_jabatan);
                    $('#email').val(data.email);
                    $('#no_telp').val(data.no_telp);
                    $('#role option[value="' + data.role + '"]').prop('selected', true);

                    $('#editPegawai').modal('show');
                }

            });
        });

        // Delete Pegawai
        $('body').on("click", '.hapus', function() {
            var idhapus = $(this).attr('data-id');
            swal({
                title: "Apakah anda yakin?",
                text: "Data yang sudah di hapus tidak dapat dikembalikan!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel !",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm) {
                if (isConfirm) {
                    location.href = 'user/hapus/' + idhapus;
                    swal("Terhapus!", "Data berhasil dihapus.", "success");
                } else {
                    swal("Cancelled", "Your imaginary file is safe :)", "error");
                }
            });
        });
    });
</script>
@endsection