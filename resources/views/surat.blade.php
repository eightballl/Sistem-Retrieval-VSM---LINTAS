@extends('master')
@section('konten')
<?php

use App\Models\Disposisi;
use App\Models\Divisi;
use Illuminate\Support\Facades\Auth;

setlocale(LC_TIME, 'ID');

$role = Auth::user()->role;
if ($role == 4) {
    $divisiSelect = Divisi::where('id', Auth::user()->id_divisi)->select('id')->first();
    $divisiID = $divisiSelect->id;
}
$iduser = Auth::user()->id;
$idDivisi = Auth::user()->id_divisi;
$role = Auth::user()->role;
$id_pegawai = $iduser;
$suratt = Disposisi::find($id_pegawai);
$fileName = Route::current()->getName();
?>
<div class="card bg-light-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Arsip Surat</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted" href="/">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Arsip Surat</li>
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
        @if ($errors->any())
        <div class="alert alert-danger alertku text-center">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <!-- <div class="d-flex justify-content-start"> -->
        <!-- @if ($role == 4)
        <button type="button" class="btn btn-info btn-rounded m-t-10 mb-2" data-bs-toggle="modal" data-bs-target="#tambahSurat">
            <i class="fs-4 ti ti-plus"></i> Tambah Surat
        </button>
        @endif -->
        <!-- <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#searchModal" style="text-align: right; float: right; color:black; margin-top: 10px;">
            <i class="ti ti-adjustments-alt me-1 fs-6"></i>
        </a> -->
        <!-- </div> -->
        <div class="table-responsive">
            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#searchModal" style="float: right; color:black;">
                Print <i class="ti ti-printer me-1 fs-6"></i>
            </a>
            <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Tanggal</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">No. Surat</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Perihal</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Jenis Surat</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Pengirim</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Penerima</h6>
                        </th>
                        <!-- <th>
                            <h6 class="fs-4 fw-semibold mb-0">File</h6>
                        </th> -->
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Status</h6>
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($surattt as $surat)
                    <!-- @if ($role == 1 || $role == 4)
                    <tr>
                        @elseif ($role == 2)
                    <tr style="{{ $surat->status == 1 ? 'background-color: #ffc7ba;' : '' }}">
                        @endif -->
                    <tr>
                        <td>
                            <h6 class="fs-4 fw-semibold mb-0">{{strftime('%A, %d-%m-%y',strtotime($surat->created_at))}}</h6>
                        </td>
                        <td>
                            <h6 class="fs-4 fw-semibold mb-0">{{$surat->no_surat}}</h6>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$surat->perihal}}</p>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$surat->kategori->nama ?? '-'}}</p>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$surat->pengirim->nama_divisi ?? '-'}}</p>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$surat->penerima->nama_divisi ?? '-'}}</p>
                        </td>
                        <!-- <td>
                            <p class="mb-0 fw-normal"><a href="javascript:void(0)" data-id="{{$surat->id}}" class="btn btn-info viewPDF"><i class="fa fa-eye"></i>&ensp;Lihat Surat</a></p>
                        </td> -->
                        <td>
                            @if ($surat->status == 1)
                            <span class="badge bg-light-danger rounded-3 py-8 text-danger fw-semibold fs-2">Manager</span>
                            @elseif ($surat->status_disposisi == 3)
                            <span class="badge bg-light-primary rounded-3 py-8 text-primary fw-semibold fs-2">Selesai</span>
                            @else
                            @foreach($surat->disposisi as $disss)
                            @if ($disss->user->role == 3)
                            <span class="badge bg-light-warning rounded-3 py-8 text-warning fw-semibold fs-2">SPV</span>
                            @elseif ($disss->user->role == 4)
                            <span class="badge bg-light-success rounded-3 py-8 text-success fw-semibold fs-2">Staff</span>
                            @endif
                            @endforeach
                            @endif
                        </td>
                        <td>
                            <div class="dropdown dropstart">
                                <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical fs-6"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a href="javascript:void(0)" data-id="{{$surat->id}}" class="dropdown-item d-flex align-items-center gap-3 viewPDF"><i class="fa fa-eye"></i>Lihat Surat</a>
                                    </li>
                                    @if ($role == 4)
                                    @if ($surat->status_disposisi == 0)
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3 editsurat" data-id="{{$surat->id}}" href="javascript:void(0)"><i class="fs-4 ti ti-edit"></i>Edit</a>
                                    </li>
                                    @endif
                                    @endif
                                    @if ($surat->status == 1)
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">Menunggu Manager</a>
                                    </li>
                                    @else
                                    @foreach($surat->disposisi as $disss)
                                    @if ($disss->user->role == 3)
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">Menunggu SPV</a>
                                    </li>
                                    @elseif ($disss->user->role == 4)
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="detail-surat-{{$disss->id}}"><i class="fs-4 ti ti-alert-circle"></i>Info</a>
                                    </li>
                                    @endif
                                    @endforeach
                                    @endif
                                    <!-- <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3 sa-params" data-id="{{$surat->id}}" id="sa-params" href="javascript:void(0)"><i class="fs-4 ti ti-trash"></i>Delete</a>
                                    </li> -->
                                    <!-- @if ($role == 2)
                                    @if ($surat->status == 1)
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3 disposisiData2" href="javascript:void(0)" data-id="{{$surat->id}}"><i class="fs-4 ti ti-file-export"></i>Disposisi</a>
                                    </li>
                                    @else
                                    @foreach($surat->disposisi as $disss)
                                    @if ($disss->user->role == 3)
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)">Menunggu SPV</a>
                                    </li>
                                    @elseif ($disss->user->role == 4)
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="detail-surat-{{$disss->id}}"><i class="fs-4 ti ti-alert-circle"></i>Info</a>
                                    </li>
                                    @endif
                                    @endforeach
                                    @endif
                                    @elseif ($role == 4) -->
                                    <!-- @if ($surat->status == 1)
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3 editsurat" data-id="{{$surat->id}}" href="javascript:void(0)"><i class="fs-4 ti ti-edit"></i>Edit</a>
                                    </li>
                                    @endif
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3 sa-params" data-id="{{$surat->id}}" id="sa-params" href="javascript:void(0)"><i class="fs-4 ti ti-trash"></i>Delete</a>
                                    </li>
                                    @endif -->
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

<!-- Start Modal Search -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Print Surat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{url('/printsurat')}}" target="_blank">
                    <label class="form-label">Tanggal Surat</label>
                    <div class="input-group mb-3">
                        <input type="date" class="form-control" name="tgl_awal">
                        <span class="input-group-text">s.d</span>
                        <input type="date" class="form-control" name="tgl_akhir">
                    </div>
                    <label class="form-label">Divisi</label>
                    <div class="input-group mb-3">
                        <select class="form-select" name="pengirim">
                            <option value="">- Pilih Pengirim -</option>
                            @foreach($divisi as $p)
                            <option value="{{$p->id}}">{{$p->nama_divisi}}</option>
                            @endforeach
                        </select>
                        <span class="input-group-text">dan</span>
                        <select class="form-select" name="penerima">
                            <option value="">- Pilih Penerima -</option>
                            @foreach($divisi as $p)
                            <option value="{{$p->id}}">{{$p->nama_divisi}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label class="form-label">Jenis Surat</label>
                    <div class="input-group mb-3">
                        <select class="form-select" name="jenis_surat">
                            <option value="">-- Jenis Surat --</option>
                            @foreach($kategori as $k)
                            <option value="{{$k->id}}">{{$k->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="basic-url" class="form-label">Perihal</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="basic-url" name="perihal">
                    </div>
                    <label for="basic-url" class="form-label">Jenis File</label>
                    <div class="input-group mb-3">
                        <select name="jenis_file" id="" class="form-select">
                            <option value="1">PDF</option>
                            <option value="2">Excel</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">
                            <i class="ti ti-printer me-1 fs-4"></i> Print
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
<!-- End Modal Search -->

<!-- Start Modal PDF -->
<div id="modalPDF" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="surattt"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe src="" align="top" id="pdfTampil" height="620" width="100%" frameborder="0" scrolling="auto"></iframe>
            </div>
        </div>
    </div>
</div>
<!-- End Modal PDF -->

<!-- Start Modal Tambah Surat -->
<!-- <div id="tambahSurat" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    Tulis Surat
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="frm_add" id="frm_add" action="simpansurat" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="no_surat" id="suratLabel" placeholder="No. Surat" required />
                            <label for="suratLabel"><i class="ti ti-file-text"></i> No. Surat</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="perihal" id="perihalLabel" placeholder="Perihal" required />
                            <label for="perihalLabel"><i class="ti ti-file-text"></i> Perihal</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select col-12" name="jenis_surat" id="jsLabel" onchange="myFunction(pp)" required>
                                <option value="">-- Jenis Surat --</option>
                                @foreach($kategori as $k)
                                <option value="{{$k->id}}">{{$k->nama}}</option>
                                @endforeach
                            </select>
                            <label for="jsLabel"><i class="ti ti-file-text"></i> Jenis Surat</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select col-12" name="pengirim" id="pengirimJS" required>
                                <option value="">-- Pilih Divisi --</option>
                                @foreach($divisi as $d)
                                <option value="{{$d->id}}"> {{$d->nama_divisi}} </option>
                                @endforeach
                            </select>
                            <label><i class="ti ti-layout"></i> Pengirim</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select col-12" name="penerima" id="penerimaJS" required>
                                <option value="">-- Pilih Divisi --</option>
                                @foreach($divisi as $d)
                                <option value="{{$d->id}}"> {{$d->nama_divisi}} </option>
                                @endforeach
                            </select>
                            <label><i class="ti ti-layout"></i> Penerima</label>
                        </div>
                        <span id="fileText" style="display: none;">Pertinjau File</span>
                        <iframe id="fileSurat" style="width: 100%; height: 350px; display: none;"></iframe>
                        <div class="form-floating mb-3">
                            <input class="form-control" type="file" name="file" id="formFile" accept="application/pdf,image/*" onchange="readURL(this);" />
                            <label><i class="ti ti-file"></i> Upload Surat</label>
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
</div> -->
<!-- End Modal Tambah Surat -->

<!-- Start Modal Edit Surat -->
<div id="editSurat" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    Update Surat
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="frm_add" id="frm_add" action="updatesurat" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="idSurat">
                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="no_surat" id="no_surat" placeholder="No. Surat" required />
                            <label><i class="ti ti-file-text"></i> No. Surat</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="perihal" id="perihal" placeholder="Perihal" required />
                            <label><i class="ti ti-file-text"></i> Perihal</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select col-12" name="jenis_surat" id="jenis_surat" required>
                                <option value="">-- Jenis Surat --</option>
                                @foreach($kategori as $k)
                                <option value="{{$k->id}}">{{$k->nama}}</option>
                                @endforeach
                            </select>
                            <label><i class="ti ti-file-text"></i> Jenis Surat</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select col-12" name="pengirim" id="pengirim" required>
                                <option value="">-- Pilih Divisi --</option>
                                @foreach($divisi as $d)
                                <option value="{{$d->id}}"> {{$d->nama_divisi}} </option>
                                @endforeach
                            </select>
                            <label><i class="ti ti-layout"></i> Pengirim</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select col-12" name="penerima" id="penerima" required>
                                <option value="">-- Pilih Divisi --</option>
                                @foreach($divisi as $d)
                                <option value="{{$d->id}}"> {{$d->nama_divisi}} </option>
                                @endforeach
                            </select>
                            <label><i class="ti ti-layout"></i> Penerima</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" type="file" name="file" id="formFile" accept="application/pdf,image/*" />
                            <label><i class="ti ti-file"></i> Upload Surat</label>
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
<!-- End M0dal Edit Surat -->

<!-- Start Modal Disposisi Manager -->
<!-- <div id="disposisi2" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    Disposisi Surat
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="frm_add" id="frm_add" action="simpandisposisi" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_surat" id="idDis" class="form-control">
                    <input type="hidden" name="status" value="2">
                    <input type="hidden" name="statusDis" value="1">
                    <input type="hidden" name="id" id="idSurat">
                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="no_surat" id="no_suratt" placeholder="No. Surat" disabled />
                            <label><i class="ti ti-file-text"></i> No. Surat</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select col-12" name="pegawai" required>
                                <option value="">-- Disposisi --</option>
                                @foreach($user as $k)
                                <option value="{{$k->id}}">{{$k->name}} - {{$k->jabatan->nm_jabatan ?? 'Admin'}}</option>
                                @endforeach
                            </select>
                            <label><i class="ti ti-file-export"></i> Disposisi</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="catatan" required cols="3" rows="1"></textarea>
                            <label><i class="ti ti-file-text"></i> Catatan</label>
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
</div> -->
<!-- End Modal Disposisi Manager -->

<!-- Start Modal Disposisi SPV -->
<!-- <div id="disposisi3" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    Disposisi Surat
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="frm_add" id="frm_add" action="simpandisposisii" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="idDispo" class="form-control">
                    <input type="hidden" name="id_surat" id="idSur" class="form-control">
                    <input type="hidden" name="status" value="3">
                    <input type="hidden" name="statusDis" value="2">
                    <div class="form-group">
                        <div class="form-floating mb-3">
                            <select class="form-select col-12" name="pegawai" required>
                                <option value="">-- Disposisi --</option>
                                @foreach($user as $k)
                                <option value="{{$k->id}}">{{$k->name}} - {{$k->jabatan->nm_jabatan ?? 'Admin'}}</option>
                                @endforeach
                            </select>
                            <label><i class="ti ti-file-export"></i> Disposisi</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="catatan" required cols="3" rows="1"></textarea>
                            <label><i class="ti ti-file-text"></i> Catatan</label>
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
</div> -->
<!-- End Modal Disposisi SPV -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php if ($role == 4) { ?>
    <script>
        // Preview Surat
        function readURL(input) {
            var fileSurat = document.getElementById('fileSurat');
            var fileText = document.getElementById('fileText');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    // Set the source of the iframe to the data URL of the selected file
                    fileSurat.src = e.target.result;

                    // Show the iframe
                    fileSurat.style.display = 'block';
                    fileText.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                // Hide the iframe if no file is selected
                fileSurat.style.display = 'none';
                fileText.style.display = 'none';
            }
        };

        // Jenis Surat
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

        $(document).ready(function() {
            // PDF
            $('body').on('click', '.viewPDF', function() {
                var id = $(this).attr('data-id');
                console.log(id);
                $.ajax({
                    url: "viewpdf?id=" + id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        $('#surattt').text(data.no_surat);
                        $('#pdfTampil').attr('src', 'pdf/' + data.file);
                        $('#modalPDF').modal('show');
                    }

                });
            });

            // Edit Surat    
            $('body').on('click', '.editsurat', function() {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: "editsurat?id=" + id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        $('#idSurat').val(data.id);
                        $('#no_surat').val(data.no_surat);
                        $('#perihal').val(data.perihal);
                        $('#jenis_surat').val(data.id_kategori);
                        $('#pengirim').val(data.id_pengirim);
                        $('#penerima').val(data.id_penerima);
                        $('#editSurat').modal('show');
                    }

                });
            });

            // Delete Surat
            $('body').on("click", '.sa-params', function() {
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
                        location.href = 'hapussurat/' + idhapus;
                        swal("Deleted!", "Data berhasil dihapus.", "success");
                    } else {
                        swal("Cancelled", "Your imaginary file is safe :)", "error");
                    }
                });
            });

            // Disposisi Manager
            $('body').on('click', '.disposisiData2', function() {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: "edit{{$fileName}}?id=" + id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        $('#idDis').val(data.id);
                        $('#no_suratt').val(data.no_surat);
                        $('#disposisi2').modal('show');
                    }

                });
            });

            // Disposisi SPV
            $('body').on('click', '.disposisiData3', function() {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: "editdisposisii?id=" + id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        $('#idDispo').val(data.id);
                        $('#idSur').val(data.id_surat);
                        $('#disposisi3').modal('show');
                    }

                });
            });
        });
    </script>
<?php } ?>
@endsection