@extends('master')
@section('konten')
<?php

use App\Models\Disposisi;
use App\Models\Divisi;
use Illuminate\Support\Facades\Auth;

$divisiSelect = Divisi::where('id', Auth::user()->id_divisi)->select('id')->first();
$divisiID = $divisiSelect->id;

$iduser = Auth::user()->id;
$nama = Auth::user()->id;
$role = Auth::user()->role;
$id_pegawai = $iduser;
$suratt = Disposisi::find($id_pegawai);
$fileName = Route::current()->getName();
?>
<div class="card bg-light-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Transaksi Barang</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted" href="/">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Transaksi Barang</li>
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
            <button type="button" class="btn btn-info btn-rounded m-t-10 mb-2" data-bs-toggle="modal" data-bs-target="#tambahTransaksi">
                <i class="fs-4 ti ti-plus"></i> Tambah Transaksi
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
                        <!-- <th>
                            <h6 class="fs-4 fw-semibold mb-0">Pegawai</h6>
                        </th> -->
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Jenis Transaksi</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Pengirim</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Penerima</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Jumlah</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Keterangan</h6>
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no = 1;
                    @endphp
                    @foreach($tbarang as $p)
                    <tr>
                        <td>
                            <h6 class="fs-4 fw-semibold mb-0">{{date('d-m-Y',strtotime($p->created_at))}}</h6>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$p->id}}</p>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$p->brg->nama_barang ?? '-'}}</p>
                        </td>
                        <!-- <td>
                            <p class="mb-0 fw-normal">{{$p->pegawai->name}}</p>
                        </td> -->
                        <td>
                            @if ($p->jenis_transaksi == 1)
                            <p class="mb-0 fw-normal">Barang Masuk</p>
                            @elseif ($p->jenis_transaksi == 2)
                            <p class="mb-0 fw-normal">Barang Keluar</p>
                            @endif
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$p->pengirim->nama_divisi ?? '-'}}</p>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$p->penerima->nama_divisi ?? '-'}}</p>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$p->jumlah}}</p>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$p->keterangan}}</p>
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
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3 hapustbarang" data-id="{{$p->id}}" id="hapustbarang" href="javascript:void(0)"><i class="fs-4 ti ti-trash"></i>Delete</a>
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
<div id="tambahTransaksi" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    Tambah Transaksi
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="frm_add" id="frm_add" action="simpantbarang" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-floating mb-3">
                        <select class="form-select col-12 barang" name="barang" id="idbarang" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barang as $b)
                            <option value="{{$b->id}}">{{$b->nama_barang}}</option>
                            @endforeach
                        </select>
                        <label><i class="ti ti-file-text"></i> Barang</label>
                    </div>
                    <input type="hidden" class="form-control" name="pegawai" value="{{$nama}}" />
                    <div class="form-floating mb-3">
                        <select class="form-select col-12" name="jenis_transaksi" id="jsLabel" onchange="myFunction(pp)" required>
                            <option value="">-- Jenis Transaksi --</option>
                            <option value="1">Barang Masuk</option>
                            <option value="2">Barang Keluar</option>
                        </select>
                        <label><i class="ti ti-file-text"></i> Jenis Transaksi</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select col-12" name="pengirim" id="pengirimJS" required>
                            <option value="">-- Pilih Pengirim --</option>
                            @foreach($divisi as $p)
                            <option value="{{$p->id}}">{{$p->nama_divisi}}</option>
                            @endforeach
                        </select>
                        <label><i class="ti ti-file-text"></i> Pengirim</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select col-12" name="penerima" id="penerimaJS" required>
                            <option value="">-- Pilih Penerima --</option>
                            @foreach($divisi as $p)
                            <option value="{{$p->id}}">{{$p->nama_divisi}}</option>
                            @endforeach
                        </select>
                        <label><i class="ti ti-file-text"></i> Penerima</label>
                    </div>
                    <div class="form-group">
                        <div id="jumlahError"></div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="jumlahnya" name="jumlah" placeholder="Jumlah" required />
                            <label><i class="ti ti-file-text"></i> Jumlah</label>
                        </div>
                        <input type="hidden" id="stok" name="stok" />
                    </div>
                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <textarea cols="5" rows="5" class="form-control" name="keterangan" placeholder="No. Transaksi" required></textarea>
                            <label><i class="ti ti-file-text"></i> Keterangan</label>
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
<!-- End Modal Tambah Transaksi -->

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // validasi stok barang
        $('body').on('change', '#jumlahnya', function() {
            var id = document.getElementById("idbarang").value;

            $.ajax({
                url: "get_stok?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    var jumlah = document.getElementById("jumlahnya").value; // Move this line here
                    var jenis_transaksi = document.getElementById("jsLabel").value;
                    $('#stok').val(data.qty);
                    // console.log(jenis_transaksi);
                    if (jenis_transaksi == 1) {
                        $('#frm_add').submit(function(event) {
                            this.submit();
                        });
                    } else {
                        $('#frm_add').submit(function(event) {
                            event.preventDefault();
                            var qty = data.qty;
                            if (qty < jumlah) {
                                $('#jumlahError').html('<p class="text-danger">Stok barang tidak mencukupi.</p>');
                                return;
                            }
                            this.submit();
                        });
                    }

                },
                error: function(xhr, status, error) {
                    console.error('Error fetching stock:', error);
                }
            });
        });
    });

    // jenis transaksi
    document.body.onchange = function(pp) {
        var element = event.target;

        if (element.id === "jsLabel") {
            var selectedValue = element.value;

            if (selectedValue === "1") {
                document.getElementById("pengirimJS").value = "";
                document.getElementById("penerimaJS").value = "{{$divisiID}}";
            } else if (selectedValue === "2") {
                document.getElementById("penerimaJS").value = "";
                document.getElementById("pengirimJS").value = "{{$divisiID}}";
            }
        }
    };

    // Edit Tbarang    
    $('body').on('click', '.edit{{$fileName}}', function() {
        var id = $(this).attr('data-id');
        $.ajax({
            url: "edit{{$fileName}}?id=" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#id').val(data.id);
                $('#barang').val(data.id_barang);
                $('#no_transaksi').val(data.no_transaksi);
                $('#jenis_transaksi').val(data.jenis_transaksi);
                $('#keterangan').val(data.keterangan);
                $('#pengirim').val(data.id_pengirim);
                $('#penerima').val(data.id_penerima);
                $('#jumlah').val(data.jumlah);
                $('#editTransaksi').modal('show');
            }

        });
    });

    // Delete Tbarang
    $('body').on("click", '.hapustbarang', function() {
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
                location.href = 'hapus{{$fileName}}/' + idhapus;
                swal("Deleted!", "Data berhasil dihapus.", "success");
            } else {
                swal("Cancelled", "Your imaginary file is safe :)", "error");
            }
        });
    });
</script>
@endsection