<?php
setlocale(LC_TIME, 'ID');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRINT LINTAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <!-- <h1 style="text-align: center;">LINTAS</h1> -->
        <img src="/img/kop_surat.jpg" width="100%">
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-bordered table-striped table-hover table-sm m-0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>No.Surat</th>
                            <th>Perihal</th>
                            <th>Jenis Surat</th>
                            <th>Pengirim</th>
                            <th>Penerima</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cari as $item)
                        <tr>
                            <td>{{strftime('%A, %d-%m-%y',strtotime($item->created_at))}}</td>
                            <td>{{ $item->no_surat}}</td>
                            <td>{{ $item->perihal}}</td>
                            <td>{{ $item->kategori->nama ?? '-'}}</td>
                            <td>{{ $item->pengirim->nama_divisi ?? '-'}}</td>
                            <td>{{ $item->penerima->nama_divisi ?? '-'}}</td>
                            <td>
                                @if ($item->status == 1)
                                <span class="text-danger">Manager</span>
                                @elseif ($item->status_disposisi == 3)
                                <span class="text-primary">Selesai</span>
                                @else
                                @foreach($item->disposisi as $disss)
                                @if ($disss->user->role == 3)
                                <span class="text-warning">SPV</span>
                                @elseif ($disss->user->role == 4)
                                <span class="text-success">Staff</span>
                                @endif
                                @endforeach
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        window.print();

        setTimeout(function() {
            window.close()
        }, 200);
        // function Redirect() {
        //     window.location = "/test";
        // }
        // setTimeout(function() {
        //     Redirect();
        // }, 1000);

        // $(function() {
        //     hide_total_value_end();
        // })

        function hide_total_value_end() {
            if ($('select[name="total_operator"]').val() == 'between')
                $('input[name="total_value_end"]').show();
            else
                $('input[name="total_value_end"]').hide();
        }
    </script>
</body>

</html>