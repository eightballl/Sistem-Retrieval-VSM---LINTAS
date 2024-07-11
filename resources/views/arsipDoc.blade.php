@extends('master')
@section('konten')
<?php

use App\Models\Disposisi;
use App\Models\Divisi;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;

setlocale(LC_TIME, 'ID');

$iduser = Auth::user()->id;
$role = Auth::user()->role;
$id_pegawai = $iduser;
$suratt = Disposisi::find($id_pegawai);
$fileName = Route::current()->getName();
$kategoriii = Kategori::all();
$divisiii = Divisi::all();
?>
<div class="card bg-light-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Arsip Dokumen</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted" href="./index.html">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Arsip Dokumen</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- <div class="card w-100 position-relative overflow-hidden" style="background-color: transparent;"> -->
<div class="container">
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h6>Input Dokumen</h6>
                    <form name="frm_add" id="frm_add" action="/saveDoc" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="noDoc" id="docNo" placeholder="No. Dokumen" required />
                                <label for="noDoc"><i class="ti ti-file-text"></i> No. Arsip</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="namaDoc" id="docNama" placeholder="Nama Dokumen" required />
                                <label for="namaDoc"><i class="ti ti-file-text"></i> Nama Dokumen</label>
                            </div>
                            <!-- <div class="form-floating mb-3">
                                <select class="form-select col-12" name="jenisDoc" id="docJenis" required>
                                    <option value="">-- Jenis Dokumen --</option>
                                    <option value="1"> PDF </option>
                                    <option value="2"> Docx </option>
                                    <option value="3"> Gambar </option>
                                </select>
                                <label><i class="ti ti-layout"></i> Jenis Dokumen</label>
                            </div> -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="kategori" id="dockategori" placeholder="Kategori" required />
                                <label for="kategori"><i class="ti ti-file-text"></i> Kategori</label>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea class="form-control" name="descdDoc" id="descDoc" placeholder="Deskripsi Dokumen" required></textarea>
                                <label for="descdDoc"><i class="ti ti-file-text"></i> Deskripsi Dokumen</label>
                            </div>
                            <textarea class="form-control" name="keywordDocx" id="keywordDoc" placeholder="Keyword Dokumen" hidden></textarea>
                            <div class="form-floating mb-3">
                                <select class="form-select col-12" name="divisi" id="divisi" required>
                                    <option value="">-- Pilih Divisi --</option>
                                    @foreach($divisiii as $d)
                                    <option value="{{$d->id}}"> {{$d->nama_divisi}} </option>
                                    @endforeach
                                </select>
                                <label><i class="ti ti-layout"></i> Divisi</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" name="created_at" id="created_at" placeholder="Tanggal Dokumen" required />
                                <label for="created_at"><i class="ti ti-file-text"></i> Tanggal Dokumen</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" type="file" name="file" id="formFile" accept="application/pdf,image/*" onchange="convertPDFToText(this.files[0])" />
                                <label><i class="ti ti-file"></i> Upload Dokumen</label>
                            </div>
                            <!-- <div class="form-floating mb-3">
                                <select class="form-select col-12" name="divisi" id="divisiId" required>
                                    <option value="">-- Pilih Divisi --</option>
                                    @foreach($divisi as $d)
                                    <option value="{{$d->id}}"> {{$d->nama_divisi}} </option>
                                    @endforeach
                                </select>
                                <label><i class="ti ti-layout"></i> Divisi</label>
                            </div> -->
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info">
                                <i class="ti ti-device-floppy me-1 fs-4"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    @if(Session::has('sukses'))
                    <div class="alert alert-success alertku text-center">
                        {{ Session::get('sukses') }}
                        <!-- <div class="errorMsg"></div> -->
                    </div>
                    @endif
                    <h5>Tampil Dokumen</h5>
                    <form class="position-relative" action="/arsipdokumen" method="GET">
                        <input type="text" class="form-control product-search ps-5" name="search" id="input_search" placeholder="Cari Dokumen..." />
                        <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                        <button type="submit" class="d-none"></button>
                    </form>
                    <div class="table-responsive rounded-2 mb-4">
                        <table id="example" class="table border text-nowrap customize-table mb-0 align-middle">
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
                                        <h6 class="fs-4 fw-semibold mb-0">Dokumen</h6>
                                    </th>
                                    <th></th>
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
                                        <p class="mb-0 fw-normal"><a href="javascript:void(0)" data-id="{{$arsipDoc->id}}" class="btn btn-info viewDoc"><i class="fa fa-eye"></i>&ensp;View Doc</a></p>
                                    </td>
                                    <td>
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
<!-- </div> -->
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
</script>
<script>
    async function convertPDFToText(file) {
        const reader = new FileReader();
        reader.onload = async function(event) {
            const typedarray = new Uint8Array(event.target.result);
            const loadingTask = pdfjsLib.getDocument({
                data: typedarray
            });
            const pdf = await loadingTask.promise;
            const maxPages = pdf.numPages;
            let text = '';
            for (let i = 1; i <= maxPages; i++) {
                const page = await pdf.getPage(i);
                const textContent = await page.getTextContent();
                textContent.items.forEach(item => {
                    text += item.str + ' ';
                });
            }
            document.getElementById('keywordDoc').value = text;
        };
        reader.readAsArrayBuffer(file);
    }

    $(document).ready(function() {
        new DataTable('#example', {
            "order": [],
            searching: false,
            paging: true,
            info: true,
            pageLength: 7,
                lengthMenu: [
                    [7],
                    [7]
                ]
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