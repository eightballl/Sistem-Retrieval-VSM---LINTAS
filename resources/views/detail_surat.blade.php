@extends('master')
@section('konten')
<?php

use Illuminate\Support\Facades\Auth;

setlocale(LC_TIME, 'ID');
$role = Auth::user()->role;
?>
<div class="card bg-light-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Detail Surat</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted" href="/">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Detail Surat</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden" style="background-color: #f5f9fa;">
    <div class="card-body p-4">
        <table class="table">
            @foreach($disposisi as $disposisi)
            <tr>
                <td width="15%">Tanggal</td>
                <td>{{strftime('%A, %d-%m-%Y',strtotime($disposisi->surat->created_at))}}</td>
            </tr>
            <tr>
                <td width="15%">No. Surat</td>
                <td>{{$disposisi->surat->no_surat ?? '-'}}</td>
            </tr>
            <tr>
                <td width="15%">Perihal</td>
                <td>{{$disposisi->surat->perihal ?? '-'}}</td>
            </tr>
            <tr>
                <td width="15%">Jenis Surat</td>
                <td>{{$disposisi->surat->kategori->nama ?? '-'}}</td>
            </tr>
            <tr>
                <td width="15%">Pengirim</td>
                <td>{{$disposisi->surat->pengirim->nama_divisi ?? '-'}}</td>
            </tr>
            <tr>
                <td width="15%">Penerima</td>
                <td>{{$disposisi->surat->penerima->nama_divisi ?? '-'}}</td>
            </tr>
            <tr>
                <td width="15%">File</td>
                <td><a href="{{ url('/pdf/'.$disposisi->surat->file) }}" class="btn btn-info"><i class="fa fa-file-pdf"></i> Download</a></td>
            </tr>
            @endforeach
        </table>

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

        <div class="row">
            <div class="card col-md-6 d-flex align-items-strech">
                <div class="position-relative d-flex flex-grow-1 flex-column">
                    <div class="chat-box p-9" style="height: calc(120vh - 442px)" data-simplebar>
                        <div class="chat-list chat active-chat" id="chat" data-user-id="1"></div>
                    </div>
                    <form data-action="{{ route('simpancatatan') }}" method="POST" enctype="multipart/form-data" id="add-user-form"> @csrf
                        <div class="px-9 py-6 border-top chat-send-message-footer">
                            <div class="d-flex align-items-center justify-content-between">
                                @if ($disposisi->surat->status_disposisi == 1 || $disposisi->surat->status_disposisi == 2)
                                <input type="hidden" name="idDisposisi" id="idDisposisi" value="{{$disposisi->id}}">
                                <input type="hidden" name="idSur" id="idSurr" value="{{$disposisi->surat->id}}">
                                <div class="d-flex align-items-center gap-2 w-85">
                                    <a class="position-relative nav-icon-hover z-index-5" href="javascript:void(0)"> <i class="ti ti-mail text-dark bg-hover-primary fs-7"></i></a>
                                    <input type="text" name="catatan" class="form-control message-type-box text-muted border-0 p-0 ms-2" placeholder="Type a Message" required />
                                </div>
                                <ul class="list-unstyled mb-0 d-flex align-items-center">
                                    @if ($role == 4)
                                    <li>
                                        <div>
                                            <label for="fileInput" class="text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative z-index-5"> <i class="ti ti-paperclip"></i></label>
                                            <input type="file" style="display: none;" name="file" id="fileInput" onchange="readURL(this);">
                                        </div>
                                    </li>
                                    @elseif ($role == 2 || $role == 3)
                                    <li>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="selesai" id="selesai">
                                            <label for="selesai">
                                                <!-- <i class="ti ti-checks"></i> -->
                                                Tutup
                                            </label>
                                        </div>
                                    </li>
                                    @endif
                                    <li>
                                        <div>
                                            <label for="submited" class="text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative z-index-5"> <i class="ti ti-brand-telegram"></i></label>
                                            <button type="submit" style="display: none;" id="submited">submit</button>
                                        </div>
                                    </li>
                                </ul>
                                @endif
                                @if ($disposisi->surat->status_disposisi == 3)
                                <div class="d-flex align-items-center list-unstyled">
                                    <h6>DITUTUP</h6>
                                </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card col-md-6 d-flex align-items-strech">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="fw-semibold mb-0 pt-2">File</h6>
                </div>
                <div class="files-chat">
                    @if ($disposisi->fileDis == null)
                    <a href="javascript:void(0)" class="hstack gap-3 file-chat-hover justify-content-between mb-9">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-1 bg-light p-6">
                                <img src="/assets/dist/images/chat/icons8-file.svg" alt="" width="24" height="24">
                            </div>
                            <div>
                                <h6 class="fw-semibold">null</h6>
                                <div class="d-flex align-items-center gap-3 fs-2 text-muted">null</div>
                            </div>
                        </div>
                    </a>
                    @else
                    <div id="fileAjax"></div>
                    @endif
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="fw-semibold mb-0">Catatan</h6>
                </div>
                <div class="files-chat">
                    <div class="d-flex align-items-center gap-3">
                        <div>
                            <div class="d-flex align-items-center gap-3 fs-3 text-muted">{{$disposisi->catatan}}</div>
                        </div>
                    </div>
                </div>
                @if ($role == 4)
                @if ($disposisi->surat->status_disposisi == 1 || $disposisi->surat->status_disposisi == 2)
                <div class="d-flex align-items-center justify-content-between pt-2">
                </div>
                <div class="files-chat">
                    <div class="d-flex align-items-center gap-3">
                        <div id="iframepdf"></div>
                        <div id="iframeimg"></div>
                    </div>
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    function readURL(input) {
        var fileType = input.files[0].type;

        var file;
        var fileText = document.getElementById('fileText');

        if (fileType === "application/pdf") {
            file = document.getElementById('filePDF');
            // Handle PDF logic here
        } else if (fileType.startsWith("image/")) {
            file = document.getElementById('fileIMG');
            // Handle image logic here
        } else {
            // Unsupported file type
            console.log('Unsupported file type');
            return; // exit the function if the file type is unsupported
        }

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                // Set the source of the file element to the data URL of the selected file
                file.src = e.target.result;

                // Show the file element
                file.style.display = 'block';
                fileText.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            // Hide the file element and fileText if no file is selected
            file.style.display = 'none';
            fileText.style.display = 'none';
        }
    }

    $(document).ready(function() {
        var idDisposisi = <?php echo $idDisposisi; ?>;
        $.ajax({
            type: 'GET',
            url: "ajaxCatatan/" + idDisposisi,
            success: function(response) {
                // console.log(response);
                var chatContent = ''; // Initialize an empty string to store chat notes
                for (var i = 0; i < response.data.length; i++) {
                    var chatajax = response.data[i].catatan;
                    var tanggal = response.data[i].created_at;
                    var date = new Date(tanggal);
                    var hours = date.getHours();
                    var minutes = date.getMinutes();
                    var formattedTime = hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0');
                    var user = response.data[i].user;
                    if (user) {
                        var pegawairole = user.role;
                        var namauser = user.name;
                        if (pegawairole == 2) {
                            chatContent += '<div class="hstack gap-3 align-items-start mb-7 justify-content-start"><div><h6 class="fs-2 text-muted">Manager - ' + namauser + '</h6><div class="p-2 bg-light rounded-1 d-inline-block text-dark fs-3">' + chatajax + '</div><div class="d-block fs-2">' + formattedTime + '</div></div></div>';
                        } else if (pegawairole == 3) {
                            chatContent += '<div class="hstack gap-3 align-items-start mb-7 justify-content-start"><div><h6 class="fs-2 text-muted">SPV - ' + namauser + '</h6><div class="p-2 bg-light rounded-1 d-inline-block text-dark fs-3">' + chatajax + '</div><div class="d-block fs-2">' + formattedTime + '</div></div></div>';
                        } else if (pegawairole == 4) {
                            chatContent += '<div class="hstack gap-3 align-items-start mb-7 justify-content-end"><div class="text-end"><h6 class="fs-2 text-muted">Staff - ' + namauser + '</h6><div class="p-2 bg-light-info text-dark rounded-1 d-inline-block fs-3">' + chatajax + '</div><div class="d-block fs-2">' + formattedTime + '</div></div></div>';
                        }
                    }
                }
                $('#chat').html(chatContent); // Set the HTML content of the #chat element
            },
        });
        $.ajax({
            type: 'GET',
            url: "ajaxFile/" + idDisposisi,
            success: function(response) {
                console.log(response);
                var filetext = '';
                var iframepdf = '';
                var iframeimg = '';
                for (var i = 0; i < response.data.length; i++) {
                    var fileajax = response.data[i].fileDis;
                    // console.log(fileajax);
                    filetext += '<a href="/disposisiFile/' + fileajax + '" class="hstack gap-3 file-chat-hover justify-content-between mb-9"><div class="d-flex align-items-center gap-3"><div class="rounded-1 bg-light p-6"><img src="/assets/dist/images/chat/icons8-file.svg" alt="" width="24" height="24"></div><h6 class="fw-semibold">' + fileajax + '</h6></div><span class="position-relative nav-icon-hover download-file"><i class="ti ti-download text-dark fs-6 bg-hover-primary"></i></span></a>';
                    iframepdf += '<iframe id="filePDF" style="max-width: 100%; max-height: 100%; width: 520px; height: 300px; display: none;"></iframe>'
                    iframeimg += '<img id="fileIMG" style="max-width: 100%; height: auto; display: none;" />'


                }

                // Set the HTML content of the #fileAjax element
                $('#fileAjax').html(filetext);
                $('#iframepdf').html(iframepdf);
                $('#iframeimg').html(iframeimg);
            },
        });

        var form = '#add-user-form';
        $(form).on('submit', function(event) {
            event.preventDefault();
            var url = $(this).attr('data-action');
            $.ajax({
                url: url,
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    $(form).trigger("reset");
                    // alert(response.success)
                    $.ajax({
                        type: 'GET',
                        url: "ajaxCatatan/" + idDisposisi,
                        success: function(response) {
                            // console.log(response);
                            var chatContent = ''; // Initialize an empty string to store chat notes
                            for (var i = 0; i < response.data.length; i++) {
                                var chatajax = response.data[i].catatan;
                                var tanggal = response.data[i].created_at;
                                var date = new Date(tanggal);
                                var hours = date.getHours();
                                var minutes = date.getMinutes();
                                var formattedTime = hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0');
                                var user = response.data[i].user;
                                if (user) {
                                    var pegawairole = user.role;
                                    var namauser = user.name;
                                    if (pegawairole == 2) {
                                        chatContent += '<div class="hstack gap-3 align-items-start mb-7 justify-content-start"><div><h6 class="fs-2 text-muted">Manager - ' + namauser + '</h6><div class="p-2 bg-light rounded-1 d-inline-block text-dark fs-3">' + chatajax + '</div><div class="d-block fs-2">' + formattedTime + '</div></div></div>';
                                    } else if (pegawairole == 3) {
                                        chatContent += '<div class="hstack gap-3 align-items-start mb-7 justify-content-start"><div><h6 class="fs-2 text-muted">SPV - ' + namauser + '</h6><div class="p-2 bg-light rounded-1 d-inline-block text-dark fs-3">' + chatajax + '</div><div class="d-block fs-2">' + formattedTime + '</div></div></div>';
                                    } else if (pegawairole == 4) {
                                        chatContent += '<div class="hstack gap-3 align-items-start mb-7 justify-content-end"><div class="text-end"><h6 class="fs-2 text-muted">Staff - ' + namauser + '</h6><div class="p-2 bg-light-info text-dark rounded-1 d-inline-block fs-3">' + chatajax + '</div><div class="d-block fs-2">' + formattedTime + '</div></div></div>';
                                    }
                                }
                            }
                            $('#chat').html(chatContent); // Set the HTML content of the #chat element
                        },
                    });
                    $.ajax({
                        type: 'GET',
                        url: "ajaxFile/" + idDisposisi,
                        success: function(response) {
                            console.log(response);
                            var filetext = '';
                            var iframepdf = '';
                            var iframeimg = '';
                            for (var i = 0; i < response.data.length; i++) {
                                var fileajax = response.data[i].fileDis;
                                filetext += '<a href="/disposisiFile/' + fileajax + '" class="hstack gap-3 file-chat-hover justify-content-between mb-9"><div class="d-flex align-items-center gap-3"><div class="rounded-1 bg-light p-6"><img src="/assets/dist/images/chat/icons8-file.svg" alt="" width="24" height="24"></div><h6 class="fw-semibold">' + fileajax + '</h6></div><span class="position-relative nav-icon-hover download-file"><i class="ti ti-download text-dark fs-6 bg-hover-primary"></i></span></a>';
                                iframepdf += '<iframe id="filePDF" style="max-width: 100%; max-height: 100%; width: 520px; height: 300px; display: none;"></iframe>'
                                iframeimg += '<img id="fileIMG" style="max-width: 100%; height: auto; display: none;" />'

                            }


                            // Set the HTML content of the #fileAjax element
                            $('#fileAjax').html(filetext);
                            $('#iframepdf').html(iframepdf);
                            $('#iframeimg').html(iframeimg);
                        },
                    });
                },
                error: function(response) {}
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