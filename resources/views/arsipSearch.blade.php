@extends('master')
@section('konten')
<?php
setlocale(LC_TIME, 'ID');
?>
<div class="card bg-light-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Pencarian Dokumen</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted" href="/">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Pencarian Dokumen</li>
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
            <form class="position-relative" action="{{ route('proses') }}" method="GET">
            <!-- <form class="position-relative" action="/searchdokumen" method="GET"> -->
                <input type="text" class="form-control product-search ps-5" name="keyword" id="keyword" placeholder="Cari Dokumen..." />
                <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                <button type="submit" class="d-none"></button>
            </form>
            <div class="table-responsive rounded-2 mb-4">
                <table id="example1" class="table border text-nowrap customize-table mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th>
                                <h6 class="fs-4 fw-semibold mb-0">Tanggal</h6>
                            </th>
                            <th>
                                <h6 class="fs-4 fw-semibold mb-0">No. Arsip</h6>
                            </th>
                            <th>
                                <h6 class="fs-4 fw-semibold mb-0">Nama Dokumen</h6>
                            </th>
                            <th>
                                <h6 class="fs-4 fw-semibold mb-0">Kategori</h6>
                            </th>
                            <th>
                                <h6 class="fs-4 fw-semibold mb-0">Keterangan</h6>
                            </th>
                            <th>
                                <h6 class="fs-4 fw-semibold mb-0">Divisi</h6>
                            </th>
                            <th>
                                <h6 class="fs-4 fw-semibold mb-0">Jenis Dokumen</h6>
                            </th>
                            <th>
                                <h6 class="fs-4 fw-semibold mb-0">Dokumen</h6>
                            </th>
                            <!-- <th></th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($arsipDoc as $arsipDoc)
                        <tr>
                            <td>
                                <h6 class="fs-4 fw-semibold mb-0">{{strftime('%A, %d-%m-%y',strtotime($arsipDoc->created_at))}}</h6>
                            </td>
                            <td>
                                <h6 class="fs-4 fw-semibold mb-0">{{$arsipDoc->nomor_dokumen}}</h6>
                            </td>
                            <td>
                                <p class="mb-0 fw-normal">{{$arsipDoc->nama_dokumen}}</p>
                            </td>
                            <td>
                                <p class="mb-0 fw-normal">{{$arsipDoc->kategori}}</p>
                            </td>
                            <td>
                                <p class="mb-0 fw-normal">{{$arsipDoc->deskripsi}}</p>
                            </td>
                            <td>
                                <p class="mb-0 fw-normal">{{$arsipDoc->divisi->nama_divisi}}</p>
                            </td>
                            <td>
                                <p class="mb-0 fw-normal">{{$arsipDoc->jenis_dokumen}}</p>
                            </td>
                            <td>
                                <p class="mb-0 fw-normal"><a href="javascript:void(0)" data-id="{{$arsipDoc->id}}" class="btn btn-info viewDoc"><i class="fa fa-eye"></i>&ensp;View Doc</a></p>
                            </td>
                            <!-- <td>
                                <div class="dropdown dropstart">
                                    <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical fs-6"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-3" href="/detail-surat-{{$arsipDoc->id}}"><i class="fs-4 ti ti-alert-circle"></i>Detail Dokumen</a>
                                        </li>
                                    </ul>
                                </div>
                            </td> -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Start Modal PDF -->
<div id="modalDOC" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="dokumenView"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe src="" align="top" id="docTampil" height="620" width="100%" frameborder="0" scrolling="auto"></iframe>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- End Modal PDF -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Mendapatkan URL saat ini
    var currentUrl = window.location.href;

    // Mengecek apakah URL memiliki parameter pencarian
    if (currentUrl.indexOf('?search=') !== -1) {
        // Menghapus parameter pencarian dari URL
        var newUrl = currentUrl.substring(0, currentUrl.indexOf('?search='));

        // Mengubah URL tanpa parameter pencarian
        window.history.replaceState({}, document.title, newUrl);
    }

    $(document).ready(function() {
        new DataTable('#example1', {
            "order": [],
            searching: false,
            paging: true,
            info: true,
        });
        // PDF
        $('body').on('click', '.viewDoc', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "/viewDoc?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#dokumenView').text(data.no);
                    $('#docTampil').attr('src', '/dokumenArsip/' + data.file);
                    $('#modalDOC').modal('show');
                }

            });
        });
    });
</script>
@endsection