@extends('master')
@section('konten')
<?php

use Carbon\Carbon;
use App\Models\Surat;

$totalSurat = Surat::count();
$disposisi = Surat::join('disposisi', 'surat.id', '=', 'disposisi.id_surat')
  ->orderBy('disposisi.created_at', 'desc')
  ->whereNotIn('surat.status_disposisi', [3])
  ->count();
$tahunSekarang = Carbon::now()->year;
setlocale(LC_TIME, 'ID');
?>
@if(Session::has('sukses'))
<div class="alert alertku alert-success">
  {{ Session::get('sukses') }}
</div>
@endif
<div class="row">
  <div class="item col-sm-3 col-xl-3">
    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#suratMasuk">
      <div class="card border-0 zoom-in bg-light-warning shadow-none">
        <div class="card-body">
          <div class="text-center">
            <img src="/assets/dist/images/svgs/surat.svg" width="50" height="50" class="mb-3" alt="" />
            <p class="fw-semibold fs-3 text-warning mb-1">
              Surat Masuk
            </p>
            <h5 class="fw-semibold text-warning mb-0">{{$suratMasuk->count()}} Surat</h5>
          </div>
        </div>
      </div>
    </a>
  </div>
  <div class="item col-sm-3 col-xl-3">
    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#suratKeluar">
      <div class="card border-0 zoom-in bg-light-danger shadow-none">
        <div class="card-body">
          <div class="text-center">
            <img src="/assets/dist/images/svgs/suratkeluar.svg" width="45" height="45" class="mb-3" alt="" />
            <p class="fw-semibold fs-3 text-danger mb-1">Surat Keluar</p>
            <h5 class="fw-semibold text-danger mb-0">{{$suratKeluar->count()}} Surat</h5>
          </div>
        </div>
      </div>
    </a>
  </div>
  <div class="item col-sm-3 col-xl-3">
    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#status">
      <div class="card border-0 zoom-in bg-light-warning shadow-none">
        <div class="card-body">
          <div class="text-center">
            <img src="/assets/dist/images/svgs/suratjalan.svg" width="50" height="50" class="mb-3" alt="" />
            <p class="fw-semibold fs-3 text-warning mb-1">
              Surat Pending
            </p>
            <h5 class="fw-semibold text-warning mb-0">{{$surattSelesai->count()}} Surat</h5>
          </div>
        </div>
      </div>
    </a>
  </div>
  <div class="item col-sm-3 col-xl-3">
    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#suratSelesai">
      <div class="card border-0 zoom-in bg-light-success shadow-none">
        <div class="card-body">
          <div class="text-center">
            <img src="/assets/dist/images/svgs/suratselesai.svg" width="50" height="50" class="mb-3" alt="" />
            <p class="fw-semibold fs-3 text-success mb-1">
              Surat Selesai
            </p>
            <h5 class="fw-semibold text-success mb-0">{{$suratselesai->count()}} Surat</h5>
          </div>
        </div>
      </div>
    </a>
  </div>
</div>

<!-- Start Modal Surat Masuk -->
<div id="suratMasuk" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center">
        <h4 class="modal-title" id="myModalLabel">
          Surat Masuk
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table id="zero_config1" class="border table-striped table-bordered text-nowrap">
          <thead class="text-dark fs-4">
            <tr>
              <th>
                <h6 class="fs-4 fw-semibold mb-0">Tanggal</h6>
              </th>
              <th>
                <h6 class="fs-4 fw-semibold mb-0">No. Surat</h6>
              </th>
              <th>
                <h6 class="fs-4 fw-semibold mb-0">Jenis Surat</h6>
              </th>
              <th>
                <h6 class="fs-4 fw-semibold mb-0">Pengirim</h6>
              </th>
              <th>
                <h6 class="fs-4 fw-semibold mb-0">Status</h6>
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach($suratMasuk as $surat)
            <tr>
              <td>
                <h6 class="fs-4 fw-semibold mb-0">{{date('d-m-Y',strtotime($surat->created_at))}}</h6>
              </td>
              <td>
                <h6 class="fs-4 fw-semibold mb-0">{{$surat->no_surat}}</h6>
              </td>
              <td>
                <p class="mb-0 fw-normal">{{$surat->kategori->nama ?? '-'}}</p>
              </td>
              <td>
                <p class="mb-0 fw-normal">{{$surat->pengirim->nama_divisi ?? '-'}}</p>
              </td>
              <td>
                @if ($surat->status == 1)
                <span class="badge bg-light-danger rounded-3 py-8 text-danger fw-semibold fs-2">Pending - Manager</span>
                @elseif ($surat->status_disposisi == 3)
                <span class="badge bg-light-primary rounded-3 py-8 text-primary fw-semibold fs-2">Selesai</span>
                @else
                @foreach($surat->disposisi as $disss)
                @if ($disss->user->role == 3)
                <span class="badge bg-light-warning rounded-3 py-8 text-warning fw-semibold fs-2">Pending - SPV</span>
                @elseif ($disss->user->role == 4)
                <span class="badge bg-light-success rounded-3 py-8 text-success fw-semibold fs-2">Pending - Staff</span>
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
</div>
<!-- End Modal Surat Masuk -->

<!-- Start Modal Surat Keluar -->
<div id="suratKeluar" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center">
        <h4 class="modal-title" id="myModalLabel">
          Surat Keluar
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table id="zero_config2" class="border table-striped table-bordered text-nowrap">
          <thead class="text-dark fs-4">
            <tr>
              <th>
                <h6 class="fs-4 fw-semibold mb-0">Tanggal</h6>
              </th>
              <th>
                <h6 class="fs-4 fw-semibold mb-0">No. Surat</h6>
              </th>
              <th>
                <h6 class="fs-4 fw-semibold mb-0">Jenis Surat</h6>
              </th>
              <th>
                <h6 class="fs-4 fw-semibold mb-0">Pengirim</h6>
              </th>
              <th>
                <h6 class="fs-4 fw-semibold mb-0">Status</h6>
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach($suratKeluar as $surat)
            <tr>
              <td>
                <h6 class="fs-4 fw-semibold mb-0">{{date('d-m-Y',strtotime($surat->created_at))}}</h6>
              </td>
              <td>
                <h6 class="fs-4 fw-semibold mb-0">{{$surat->no_surat}}</h6>
              </td>
              <td>
                <p class="mb-0 fw-normal">{{$surat->kategori->nama ?? '-'}}</p>
              </td>
              <td>
                <p class="mb-0 fw-normal">{{$surat->pengirim->nama_divisi ?? '-'}}</p>
              </td>
              <td>
                @if ($surat->status == 1)
                <span class="badge bg-light-danger rounded-3 py-8 text-danger fw-semibold fs-2">Pending - Manager</span>
                @elseif ($surat->status_disposisi == 3)
                <span class="badge bg-light-primary rounded-3 py-8 text-primary fw-semibold fs-2">Selesai</span>
                @else
                @foreach($surat->disposisi as $disss)
                @if ($disss->user->role == 3)
                <span class="badge bg-light-warning rounded-3 py-8 text-warning fw-semibold fs-2">Pending - SPV</span>
                @elseif ($disss->user->role == 4)
                <span class="badge bg-light-success rounded-3 py-8 text-success fw-semibold fs-2">Pending - Staff</span>
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
</div>
<!-- End Modal Surat Keluar -->

<!-- Start Modal Surat Selesai -->
<div id="suratSelesai" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center">
        <h4 class="modal-title" id="myModalLabel">
          Surat Selesai
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table id="zero_config5" class="border table-striped table-bordered text-nowrap">
          <thead class="text-dark fs-4">
            <tr>
              <th>
                <h6 class="fs-4 fw-semibold mb-0">Tanggal</h6>
              </th>
              <th>
                <h6 class="fs-4 fw-semibold mb-0">No. Surat</h6>
              </th>
              <th>
                <h6 class="fs-4 fw-semibold mb-0">Jenis Surat</h6>
              </th>
              <th>
                <h6 class="fs-4 fw-semibold mb-0">Pengirim</h6>
              </th>
              <th>
                <h6 class="fs-4 fw-semibold mb-0">Status</h6>
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach($suratselesai as $surat)
            <tr>
              <td>
                <h6 class="fs-4 fw-semibold mb-0">{{date('d-m-Y',strtotime($surat->created_at))}}</h6>
              </td>
              <td>
                <h6 class="fs-4 fw-semibold mb-0">{{$surat->no_surat}}</h6>
              </td>
              <td>
                <p class="mb-0 fw-normal">{{$surat->kategori->nama ?? '-'}}</p>
              </td>
              <td>
                <p class="mb-0 fw-normal">{{$surat->pengirim->nama_divisi ?? '-'}}</p>
              </td>
              <td>
                @if ($surat->status_disposisi == 3)
                <span class="badge bg-light-primary rounded-3 py-8 text-primary fw-semibold fs-2">Selesai</span>
              </td>
              @endif
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- End Modal Surat Selesai -->

<!-- Start Modal Status Surat -->
<div id="status" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center">
        <h4 class="modal-title" id="myModalLabel">
          Surat Pending
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table id="zero_config4" class="border table-striped table-bordered text-nowrap">
          <thead class="text-dark fs-4">
            <tr>
              <th>
                <h6 class="fs-4 fw-semibold mb-0">Tanggal</h6>
              </th>
              <th>
                <h6 class="fs-4 fw-semibold mb-0">No. Surat</h6>
              </th>
              <th>
                <h6 class="fs-4 fw-semibold mb-0">Jenis Surat</h6>
              </th>
              <th>
                <h6 class="fs-4 fw-semibold mb-0">Pengirim</h6>
              </th>
              <th>
                <h6 class="fs-4 fw-semibold mb-0">Status</h6>
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach($surattSelesai as $suratselesai)
            <tr>
              <td>
                <h6 class="fs-4 fw-semibold mb-0">{{date('d-m-Y',strtotime($suratselesai->created_at))}}</h6>
              </td>
              <td>
                <h6 class="fs-4 fw-semibold mb-0">{{$suratselesai->no_surat}}</h6>
              </td>
              <td>
                <p class="mb-0 fw-normal">{{$suratselesai->kategori->nama ?? '-'}}</p>
              </td>
              <td>
                <p class="mb-0 fw-normal">{{$suratselesai->pengirim->nama_divisi ?? '-'}}</p>
              </td>
              <td>
                @if ($suratselesai->status == 1)
                <span class="badge bg-light-danger rounded-3 py-8 text-danger fw-semibold fs-2">Pending - Manager</span>
                @elseif ($suratselesai->status_disposisi == 3)
                <span class="badge bg-light-primary rounded-3 py-8 text-primary fw-semibold fs-2">Selesai</span>
                @else
                @foreach($suratselesai->disposisi as $disss)
                @if ($disss->user->role == 3)
                <span class="badge bg-light-warning rounded-3 py-8 text-warning fw-semibold fs-2">Pending - SPV</span>
                @elseif ($disss->user->role == 4)
                <span class="badge bg-light-success rounded-3 py-8 text-success fw-semibold fs-2">Pending - Staff</span>
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
</div>
<!-- End Modal Status Surat -->


<!--  Row 3 -->
<div class="row">
  <div class="col-lg-12 d-flex align-items-strech">
    <div class="card w-100 position-relative overflow-hidden">
      <div class="card-body">
        <!-- <div class="d-flex align-items-center justify-content-between mb-4">
          <h5 class="card-title mb-0 fw-semibold">
            Data Surat
          </h5>
          <div>
            <form action="/home">
              <label class="form-label">Tahun Surat</label>
              <select class="form-select text-dark" name="tahun" id="selectTahun">
                <?php
                for ($tahun = 2020; $tahun <= $tahunSekarang; $tahun++) {
                  $selected = ($tahun == request('tahun', $tahunSekarang)) ? 'selected' : '';
                  echo "<option value=\"$tahun\" $selected>$tahun</option>";
                }
                ?>
              </select>
            </form>
          </div>
        </div>
        <div id="jumlah"></div>
        <div class="d-flex align-items-center justify-content-center">
          <div class="me-4">
            <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
            <span>Surat Masuk</span>
          </div>
          <div>
            <span class="round-8 bg-secondary rounded-circle me-2 d-inline-block"></span>
            <span>Surat Keluar</span>
          </div>
        </div> -->
        <h5 class="card-title mb-0 fw-semibold">
          Data Surat
        </h5>
        <iframe src="/datasurat" width="100%" height="415px" frameborder="0" scrolling="no"></iframe>
      </div>
    </div>
  </div>
</div>

<script src="/assets/dist/libs/jquery/dist/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- ---------------------------------------------- -->
<!-- current page js files -->
<!-- ---------------------------------------------- -->
<script src="/assets/dist/js/apps/chat.js"></script>
<script src="/assets/dist/libs/apexcharts/dist/apexcharts.min.js"></script>
<script src="/assets/dist/js/widgets-charts.js"></script>
<script>
  // Menambahkan event listener untuk mendeteksi perubahan pada elemen select
  document.getElementById('selectTahun').addEventListener('change', function() {
    // Mengirimkan formulir saat terjadi perubahan pada elemen select
    this.form.submit();
  });

  $(function() {
    // =====================================
    // Diagram Surat
    // =====================================
    var options = {
      series: [{
        name: "Surat Masuk",
        data: [<?php
                foreach ($chartSuratMasukCount as $masuk) {
                  echo '"' . $masuk->jumlahMasuk . '",';
                } ?>],
      }, {
        name: "Surat Keluar",
        data: [
          <?php
          foreach ($chartSuratMasukCount as $masuk) {
            echo '"' . $masuk->jumlahKeluar . '",';
          } ?>
        ],
      }, ],

      chart: {
        toolbar: {
          show: false,
        },
        height: 310,
        type: "bar",
        fontFamily: "Plus Jakarta Sans', sans-serif",
        foreColor: "#adb0bb",
      },
      colors: ["var(--bs-primary)", "var(--bs-secondary)"],
      plotOptions: {
        bar: {
          borderRadius: [6],
          horizontal: false,
          barHeight: '60%',
          columnWidth: '40%',
          borderRadiusApplication: 'end',
          borderRadiusWhenStacked: 'all',
        }
      },
      stroke: {
        show: false
      },

      dataLabels: {
        enabled: false,
      },

      legend: {
        show: false,
      },

      grid: {
        show: false,
      },

      yaxis: {
        tickAmount: 4,
      },

      xaxis: {
        categories: [
          <?php
          foreach ($chartSuratMasukCount as $masuk) {
            echo '["' . $masuk->bulan . '"],';
          } ?>
        ],
        axisTicks: {
          show: false
        }
      },

      tooltip: {
        theme: 'dark',
        fillSeriesColor: false,
        x: {
          show: false
        }
      },

    };

    var chart = new ApexCharts(
      document.querySelector("#jumlah"),
      options
    );
    chart.render();
  });
</script>
@endsection