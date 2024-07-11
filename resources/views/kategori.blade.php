@extends('master')

@section('konten')

<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

$roleadmin = Auth::user()->role;
$fileName = Route::current()->getName();

?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

                </div>

                <div class="card-body">

                    @if(Session::has('sukses'))
                    <div class="alert alertku alert-success">
                        {{ Session::get('sukses') }}
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title"></h3>
                                    <button type="button" class="btn btn-success btn-primary waves-effect waves-light" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>
                                        Tambah {{$fileName}}</button>
                                </div>

                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="table-responsive">
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th width="1%">No</th>
                                                            <th>Nama</th>
                                                            <th>Keterangan</th>
                                                            <th width="5%">Option</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                        $no = 1;
                                                        @endphp
                                                        @foreach($$fileName as $f)
                                                        <tr>
                                                            <td>{{$no++}}</td>
                                                            <td>{{$f->nama}}</td>
                                                            <td>{{$f->keterangan}}</td>

                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-xs btn-success edit{{$fileName}}" data-id="{{$f->id}}"><i class="fa fa-pencil"></i></button>

                                                                <!-- <a href="hapus{{$fileName}}/{{$f->id}}" class="btn btn-xs btn-danger" onclick="return confirm('Yakin akan hapus data ??')"><i class="fa fa-trash"></i></a> -->


                                                                <button type="button" data-id="{{$f->id}}" class="btn btn-xs btn-danger sa-params" id="sa-params"><i class="fa fa-trash"></i></button>


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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- MODAL TAMBAH DATA -->
<!-- MODAL TAMBAH DATA -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Tambah Data {{$fileName}}</h4>
            </div>
            <div class="modal-body">
                <form name="frm_add" id="frm_add" action="simpan{{$fileName}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group"><label class="control-label">Nama</label>
                        <div><input type="text" name="nama" id="" placeholder="Nama" class="form-control" required></div>
                    </div>
                    <div class="form-group"><label class="control-label">Keterangan</label>
                        <div>
                            <textarea class="form-control" name="keterangan" id="" cols="30" rows="10" required></textarea>
                        </div>
                    </div>

                    <div class="form-group"><label class="control-label"></label>
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL TAMBAH DATA -->
<!-- END MODAL TAMBAH DATA -->

<!-- MODAL UBAH DATA -->
<!-- MODAL UBAH DATA -->

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

                    <div class="form-group"><label class="control-label">Nama</label>
                        <div><input type="text" name="nama" id="nama" placeholder="Merek HP" class="form-control" required></div>
                    </div>
                    <div class="form-group"><label class="control-label">Keterangan</label>
                        <div><input type="text" name="keterangan" id="keterangan" placeholder="Tipe" class="form-control" required>
                        </div>
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
</div>
<!-- END MODAL UBAH DATA -->
<!-- END MODAL UBAH DATA -->


<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
    $(document).ready(function() {
        //edit data
        $('body').on('click', '.edit{{$fileName}}', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "edit{{$fileName}}?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#id').val(data.id);
                    $('#nama').val(data.nama);
                    $('#keterangan').val(data.keterangan);
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
                cancelButtonText: "No, cancel !",
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