@extends('master')
@section('konten')

<?php

use Illuminate\Support\Facades\Auth;

$idUser = Auth::user()->id;
$idDivisi = Auth::user()->id_divisi;
$role = Auth::user()->role;
?>

<div class="card bg-light-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Perbaikan Barang</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted" href="/">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Perbaikan Barang</li>
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
            @if ($role == 1 || 2 || 4)
            <button type="button" class="btn btn-info btn-rounded m-t-10 mb-2" data-bs-toggle="modal" data-bs-target="#tambahPerbaikan">
                <i class="fs-4 ti ti-plus"></i> Perbaikan Barang
            </button>
            @endif
        </div>
        <div class="table-responsive rounded-2 mb-4">
            <a href="/export/surat" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#searchModal" style="float: right;">
                <i class="ti ti-adjustments-alt me-1 fs-4"></i>
            </a>
            <table id="zero_config" class="border table-striped table-bordered text-nowrap">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Tanggal</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">No</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Barang</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Pengirim</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Nama</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Penerima</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Nama</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Keterangan</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Status</h6>
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no = 1;
                    @endphp
                    @foreach($perbaikan as $p)
                    <tr>
                        <td>
                            <h6 class="fs-4 fw-semibold mb-0">{{date('d-m-Y',strtotime($p->created_at))}}</h6>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$p->id}}</p>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$p->jenis_barang}}</p>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$p->pengirim->nama_divisi ?? '-'}}</p>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$p->nm_pengirim->name ?? '-'}}</p>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$p->penerima->nama_divisi ?? '-'}}</p>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$p->nm_penerima->name ?? '-'}}</p>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$p->keterangan}}</p>
                        </td>
                        <td>
                            @if ($p->status == 1)
                            <span class="badge bg-light-success rounded-3 py-8 text-success fw-semibold fs-2">Diterima</span>
                            @elseif ($p->status == 2)
                            <span class="badge bg-light-warning rounded-3 py-8 text-warning fw-semibold fs-2">Dikerjakan</span>
                            @elseif ($p->status == 3)
                            <span class="badge bg-light-primary rounded-3 py-8 text-primary fw-semibold fs-2">Selesai</span>
                            @endif
                        </td>
                        <td>
                            <div class="dropdown dropstart">
                                <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical fs-6"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @if ($role == 2 || 1 || 4)
                                    <!-- <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3 edittbarang" data-id="{{$p->id}}" href=" javascript:void(0)"><i class="fs-4 ti ti-edit"></i>Edit</a>
                                    </li> -->
                                    @if ($p->status == 1)
                                    <li>
                                        <form action="dikerjakan" method="post">
                                            @csrf
                                            <input type="hidden" value="{{$p->id}}" name="idPerbaikan">
                                            <button type="submit" class="dropdown-item d-flex align-items-center gap-3"><i class="fs-4 ti ti-circle"></i>Proses Dikerjakan</button>
                                            <!-- <input type="button" class="dropdown-item d-flex align-items-center gap-3"><i class="fs-4 ti ti-circle"></i>Proses Dikerjakan</input> -->
                                        </form>
                                    </li>
                                    @elseif ($p->status == 2)
                                    <li>
                                        <form action="selesai" method="post">
                                            @csrf
                                            <input type="hidden" value="{{$p->id}}" name="idPerbaikan">
                                            <button type="submit" class="dropdown-item d-flex align-items-center gap-3"><i class="fs-4 ti ti-circle"></i>Selesai</button>
                                            <!-- <input type="button" class="dropdown-item d-flex align-items-center gap-3"><i class="fs-4 ti ti-circle"></i>Proses Dikerjakan</input> -->
                                        </form>
                                        <!-- <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)"><i class="fs-4 ti ti-circle"></i>Selesai</a> -->
                                    </li>
                                    @endif
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3 detail" data-id="{{$p->id}}" href="javascript:void(0)"><i class="fs-4 ti ti-alert-circle"></i>Detail</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3 sa-params" data-id="{{$p->id}}" id="hapustbarang" href="javascript:void(0)"><i class="fs-4 ti ti-trash"></i>Delete</a>
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

<!-- Start Modal Tambah Perbaikan -->
<div id="tambahPerbaikan" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    Tambah Perbaikan Barang
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="frm_add" id="frm_add" action="simpanperbaikan" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-floating mb-3">
                        <input class="form-control" type="text" name="barang" placeholder="Nama Barang" />
                        <label><i class="ti ti-file-text"></i> Nama Barang</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" type="text" name="jenis_barang" placeholder="Jenis Barang" />
                        <label><i class="ti ti-file-text"></i> Jenis Barang</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" type="text" name="tipe_barang" placeholder="Tipe Barang" />
                        <label><i class="ti ti-file-text"></i> Tipe Barang</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" type="text" name="warna_barang" placeholder="Warna Barang" />
                        <label><i class="ti ti-file-text"></i> Warna Barang</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select col-12" name="pengirim" id="pengirim" required>
                            <option value="">-- Pilih Pengirim --</option>
                            @foreach($divisi as $p)
                            <option value="{{$p->id}}">{{$p->nama_divisi}}</option>
                            @endforeach
                        </select>
                        <label><i class="ti ti-file-text"></i> Divisi Pengirim</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select col-12" name="nm_pengirim" id="nm_pengirim" required disabled>
                            <option value="">-- Nama Pengirim --</option>
                            @foreach($user as $p)
                            <option value="{{$p->id}}">{{$p->name}} - {{$p->jabatan->nm_jabatan}}</option>
                            @endforeach
                        </select>
                        <label><i class="ti ti-file-text"></i> Nama Pengirim</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select col-12" name="penerima" required>
                            <option value="">-- Pilih Penerima --</option>
                            @foreach($divisi as $p)
                            <option value="{{$p->id}}" {{$p->id == $idDivisi ? 'selected' : ''}}>{{$p->nama_divisi}}</option>
                            @endforeach
                        </select>
                        <label><i class="ti ti-file-text"></i> Penerima</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select col-12" name="nm_penerima" required>
                            <option value="">-- Nama Penerima --</option>
                            @foreach($user as $p)
                            <option value="{{$p->id}}" {{$p->id == $idUser ? 'selected' : ''}}>{{$p->name}}</option>
                            @endforeach
                        </select>
                        <label><i class="ti ti-file-text"></i> Nama Penerima</label>
                    </div>
                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <textarea cols="5" rows="5" class="form-control" name="keterangan" placeholder="No. Transaksi" required></textarea>
                            <label><i class="ti ti-file-text"></i> Keterangan</label>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" type="file" name="file" id="formFile" accept="application/pdf,image/*" />
                        <label><i class="ti ti-file"></i> Photo Barang</label>
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
<!-- End Modal Tambah Perbaikan -->

<!-- Start Model Detail -->
<div id="detail" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Detail Perbaikan <span id="jenisBarang"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- <div class="modal-body"> -->
            <!-- <table>
            <tr>
                <td>Nama Barang</td>
                <td>: <p id="barang"></p></td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td>: <p id="keterangan"></p></td>
            </tr>
            <tr>
                <td>Gambar Barang</td>
                <td>: <img height="200px" width="200px" id="file"></td>
            </tr>
        </table> -->
            <div class="col-md-12">
                <!-- <div class="modal-body">
                    <label class="col-md-4">Nama Barang</label>
                    <span class="col-md-8">: <span id="barang"></span></span>
                </div> -->
                <div class="modal-body">
                    <label class="col-md-4">Nama Barang</label>
                    <span class="col-md-8"><span style="font-weight: bold">:</span> <span id="barang"></span></span>
                </div>
                <div class="modal-body">
                    <label class="col-md-4">Tipe Barang</label>
                    <span class="col-md-8"><span style="font-weight: bold">:</span> <span id="tipeBarang"></span></span>
                </div>
                <div class="modal-body">
                    <label class="col-md-4">Warna Barang</label>
                    <span class="col-md-8"><span style="font-weight: bold">:</span> <span id="warnaBarang"></span></span>
                </div>
                <div class="modal-body">
                    <label class="col-md-4">Keterangan</label>
                    <span class="col-md-8"><span style="font-weight: bold">:</span> <span id="keterangan"></span></span>
                </div>
                <div class="modal-body">
                    <label class="col-md-4">Gambar Barang</label>
                    <span class="col-md-8"><span style="font-weight: bold">:</span> <img height="200px" width="200px" id="file"></span>
                </div>
                <!-- <div class="modal-body">
                    <label class="col-md-4">Diterima</label>
                    <span class="col-md-8">: Tanggal</span>
                </div> -->
                <div class="modal-body">
                    <label class="col-md-4">Dikerjakan</label>
                    <span class="col-md-8"><span style="font-weight: bold">:</span> <span id="dikerjakan"></span></span>
                </div>
                <div class="modal-body">
                    <label class="col-md-4">Selesai</label>
                    <span class="col-md-8"><span style="font-weight: bold">:</span> <span id="selesai"></span></span>
                </div>
            </div>
            <!-- </div> -->
        </div>
    </div>
</div>
<!-- End Modal Detail -->

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {

        // Pengirim
        $('#pengirim').change(function() {
            var selectedDivisiId = $(this).val();

            // Enable or disable the Nama Pengirim select based on the selected Divisi
            $('#nm_pengirim').prop('disabled', !selectedDivisiId);

            if (selectedDivisiId) {
                $.ajax({
                    url: '/getUsersByDivisi/' + selectedDivisiId,
                    type: 'GET',
                    success: function(data) {
                        $('#nm_pengirim').empty().append('<option value="">-- Nama Pengirim --</option>');
                        $.each(data, function(key, value) {
                            $('#nm_pengirim').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            } else {
                // If no Divisi is selected, clear and disable the Nama Pengirim select
                $('#nm_pengirim').empty().append('<option value="">-- Nama Pengirim --</option>').prop('disabled', true);
            }
        });

        // Delete
        $('body').on("click", '.sa-params', function() {
            var idhapus = $(this).attr('data-id');
            swal({
                title: "Apakah anda yakin?",
                text: "Data yang sudah di hapus tidak dapat dikembalikan!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Tidak !",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm) {
                if (isConfirm) {
                    location.href = '/perbaikan/delete/' + idhapus;
                    swal("Terhapus!", "Data berhasil dihapus.", "success");
                } else {
                    swal("Batal", "Data tidak dihapus :)", "error");
                }
            });
        });

        // Detail
        $('body').on('click', '.detail', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "/perbaikan/detail?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#noTransaksi').text(data.id);
                    $('#barang').text(data.nm_barang);
                    $('#jenisBarang').text(data.jenis_barang);
                    $('#tipeBarang').text(data.tipe_barang);
                    $('#warnaBarang').text(data.warna_barang);
                    $('#keterangan').text(data.keterangan);
                    $('#dikerjakan').text(data.dikerjakan);
                    $('#selesai').text(data.selesai);
                    $('#file').attr('src', '/perbaikanBarang/' + data.file);
                    $('#detail').modal('show');
                }

            });
        });
    });
</script>
@endsection