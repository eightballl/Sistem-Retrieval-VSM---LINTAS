@extends('master')

@section('konten')

<?php

use Illuminate\Support\Facades\Auth;

$roleadmin = Auth::user()->role;
$fileName = Route::current()->getName();
?>

<!-- Alert -->
<style>
    .alertku {
        display: none;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

                </div>

                <div class="card-body">

                    @if(Session::has('sukses'))
                    <div class="alert alert-success alertku fade in">
                        {{ Session::get('sukses') }}
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <button type="button" class="btn btn-success btn-primary waves-effect waves-light" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>
                                        Catatan</button>
                                </div>

                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="table-responsive">
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th width="1%">No</th>
                                                            <th width="5%">Disposisi</th>
                                                            <th>Pegawai</th>
                                                            <th>Catatan</th>
                                                            <th width="5%">Option</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                        $no = 1;
                                                        @endphp
                                                        @foreach($catatan as $p)
                                                        <tr>
                                                            <td>{{$no++}}</td>
                                                            <td>{{$p->disposisi->id ?? '-'}}</td>
                                                            <td>{{$p->pegawai->nama ?? '-'}}</td>
                                                            <td>{{$p->catatan}}</td>

                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-xs btn-success edit{{$fileName}}" data-id="{{$p->id}}"><i class="fa fa-pencil"></i></button>

                                                                <button type="button" data-id="{{$p->id}}" class="btn btn-xs btn-danger sa-params" id="sa-params"><i class="fa fa-trash"></i></button>

                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>

                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End row -->
                </div>
            </div>

        </div>
    </div>
</div>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Tambah Catatan</h4>
            </div>
            <div class="modal-body">
                <form name="frm_add" id="frm_add" action="simpan{{$fileName}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group"><label class="control-label">Disposisi</label>
                        <select class="form-control" name="disposisi" required>
                            <option value="">-Disposisi</option>
                            @foreach($disposisi as $a)
                            <option value="{{$a->id}}">{{$a->id}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group"><label class="control-label">Pegawai</label>
                        <select class="form-control" name="pegawai" required>
                            <option value="">-Pegawai</option>
                            @foreach($pegawai as $w)
                            <option value="{{$w->id}}">{{$w->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group"><label class="control-label">Catatan</label>
                        <input type="text" name="catatan" class="form-control">
                    </div>
                    <!-- <input type="hidden" class="form-control" name="created" id="created" aria-describedby="created" value="{{ Auth::user()->name }}"> -->

                    <div class="form-group"><label class="control-label"></label>
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="modal_edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Ubah Data {{$fileName}}</h4>
            </div>
            <div class="modal-body">
                <form name="frm_add" id="frm_add" action="update{{$fileName}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group"><label class="control-label">Disposisi</label>
                        <select class="form-control" name="disposisi" id="disposisi" required>
                            <option value="">-Disposisi</option>
                            @foreach($disposisi as $a)
                            <option value="{{$a->id}}">{{$a->id}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group"><label class="control-label">Pegawai</label>
                        <select class="form-control" name="pegawai" id="pegawai" required>
                            <option value="">-Pegawai</option>
                            @foreach($pegawai as $w)
                            <option value="{{$w->id}}">{{$w->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group"><label class="control-label">Catatan</label>
                        <input type="text" name="catatan" id="catatan" class="form-control">
                    </div>


                    <div class="modal-footer">
                    </div>

                    <input type="hidden" name="id" id="id" value="">
                    <div class="form-group"><label class="control-label"></label>
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Ubah</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
    $(document).ready(function() {

        //
        $(".alertku").delay().fadeIn().delay(3000).fadeOut();
        //edit data
        $('body').on('click', '.edit{{$fileName}}', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "edit{{$fileName}}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#id').val(data.id);
                    $('#disposisi').val(data.id_disposisi);
                    $('#pegawai').val(data.id_pegawai);
                    $('#catatan').val(data.catatan);
                    $('#modal_edit').modal('show');
                }

            });
        });

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
                    location.href = 'hapus{{$fileName}}/' + idhapus;
                    swal("Deleted!", "Data berhasil dihapus.", "success");
                } else {
                    swal("Cancelled", "Your imaginary file is safe :)", "error");
                }
            });
        });

    });
</script>
@endsection