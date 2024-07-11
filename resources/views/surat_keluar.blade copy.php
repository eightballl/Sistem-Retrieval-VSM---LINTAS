@extends('master')
@section('konten')
<?php

use App\Models\Disposisi;
use Illuminate\Support\Facades\Auth;

setlocale(LC_TIME, 'ID');

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
                <h4 class="fw-semibold mb-8">Surat Keluar</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted" href="/">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Surat Keluar</li>
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
        <div class="table-responsive rounded-2 mb-4">
            <!-- <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#searchModal" style="float: right; color:black;">
                <i class="ti ti-adjustments-alt me-1 fs-6"></i>
            </a> -->
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
                    @foreach($disposisi as $disposisi)
                    <tr>
                        <td>
                            <h6 class="fs-4 fw-semibold mb-0">{{strftime('%A, %d-%m-%y',strtotime($disposisi->created_at))}}</h6>
                        </td>
                        <td>
                            <h6 class="fs-4 fw-semibold mb-0">{{$disposisi->no_surat}}</h6>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$disposisi->perihal}}</p>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$disposisi->kategori->nama}}</p>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$disposisi->pengirim->nama_divisi ?? '-'}}</p>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal">{{$disposisi->penerima->nama_divisi ?? '-'}}</p>
                        </td>
                        <!-- <td>
                            <p class="mb-0 fw-normal"><a href="javascript:void(0)" data-id="{{$disposisi->id_surat}}" class="btn btn-info viewPDF"><i class="fa fa-eye"></i>&ensp;Lihat Surat</a></p>
                        </td> -->

                        <td>
                            @if ($role == 2)
                            <span class="badge bg-light-danger rounded-3 py-8 text-danger fw-semibold fs-2">Manager</span>
                            @else
                            @if ($disposisi->user->id_jabatan == 2)
                            <span class="badge bg-light-warning rounded-3 py-8 text-warning fw-semibold fs-2">SPV</span>
                            @elseif ($disposisi->user->id_jabatan == 3)
                            <span class="badge bg-light-success rounded-3 py-8 text-success fw-semibold fs-2">Staff</span>
                            @endif
                            @endif
                        </td>
                        <td>
                            <div class="dropdown dropstart">
                                <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical fs-6"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @if ($role == 2)
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3 MNGDisposisi" href="javascript:void(0)" data-id="{{$disposisi->id}}"><i class="fs-4 ti ti-file-export"></i>Disposisi</a>
                                    </li>
                                    @elseif ($role == 3)
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3 SPVDisposisi" href="javascript:void(0)" data-id="{{$disposisi->id}}"><i class="fs-4 ti ti-file-export"></i>Disposisi</a>
                                    </li>
                                    @endif
                                    @if ($role == 1 || $role == 3 || $role == 4)
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="/detail-surat-{{$disposisi->id}}"><i class="fs-4 ti ti-alert-circle"></i>Info</a>
                                    </li>
                                    @endif
                                    <li>
                                        @if ($role == 2)
                                        <a href="javascript:void(0)" data-id="{{$disposisi->id}}" class="dropdown-item d-flex align-items-center gap-3 viewPDF"><i class="fa fa-eye"></i>Lihat Surat</a>
                                        @else
                                        <a href="javascript:void(0)" data-id="{{$disposisi->id_surat}}" class="dropdown-item d-flex align-items-center gap-3 viewPDF"><i class="fa fa-eye"></i>Lihat Surat</a>
                                        @endif
                                    </li>
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

<!-- Start Modal Disposisi Manager -->
<div id="disposisi2" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    Disposisi Surat
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="frm_add" id="frm_add" action="/simpandisposisi" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_surat" id="idDis" class="form-control">
                    <input type="hidden" name="status" value="2">
                    <input type="hidden" name="statusDis" value="1">
                    <input type="hidden" name="id" id="idSurat">
                    <input type="hidden" name="kategori" id="id_kategori">
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
</div>
<!-- End Modal Disposisi Manager -->

<!-- Start Modal Disposisi SPV -->
<div id="disposisi" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    Disposisi Surat
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="frm_add" id="frm_add" action="/simpandisposisii" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="idDispo" class="form-control">
                    <input type="hidden" name="id_surat" id="idSur" class="form-control">
                    <input type="hidden" name="status" value="3">
                    <input type="hidden" name="statusDis" value="2">
                    <input type="hidden" name="kategori" value="2">
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
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- End Modal Disposisi SPV -->

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
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- End Modal Gambar -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Disposisi SPV
        $('body').on('click', '.SPVDisposisi', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "/editdisposisi?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#idDispo').val(data.id);
                    $('#idSur').val(data.id_surat);
                    $('#disposisi').modal('show');
                }

            });
        });

        // Disposisi Manager
        $('body').on('click', '.MNGDisposisi', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "/editsurat?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#idDis').val(data.id);
                    $('#no_suratt').val(data.no_surat);
                    $('#id_kategori').val(data.id_kategori);
                    $('#disposisi2').modal('show');
                }

            });
        });

        // PDF
        $('body').on('click', '.viewPDF', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "/viewpdf?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#surattt').text(data.no_surat);
                    $('#pdfTampil').attr('src', '/pdf/' + data.file);
                    $('#modalPDF').modal('show');
                }

            });
        });
    });
</script>
@endsection