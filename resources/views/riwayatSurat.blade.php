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
                <h4 class="fw-semibold mb-8">Surat Selesai</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted" href="/">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Surat Selesai</li>
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
        <div class="table-responsive">
            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#searchModal" style="text-align: right; float: right; color:black; margin-bottom: 10px;">
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
                    @foreach($surat as $surat)
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
                            @if ($surat->status_disposisi == 3)
                            <span class="badge bg-light-primary rounded-3 py-8 text-primary fw-semibold fs-2">Selesai</span>
                            @endif
                        </td>
                        <td>
                            <div class="dropdown dropstart">
                                <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical fs-6"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @if ($surat->status_disposisi == 3)
                                    @foreach($surat->disposisi as $disss)
                                    <a class="dropdown-item d-flex align-items-center gap-3" href="/detail-surat-{{$disss->id}}"><i class="fs-4 ti ti-alert-circle"></i>Info</a>
                                    @endforeach
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

<!-- Start Modal Search -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Print Surat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{url('/printsuratselesai')}}" target="_blank">
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
@endsection