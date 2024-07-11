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
<!--  Row 3 -->
<div class="row">
  <div class="col-lg-12 d-flex align-items-strech">
    <div class="card w-100 position-relative overflow-hidden">
      <div class="card-body">
        <h5 class="card-title mb-0 fw-semibold">
          Data Surat
        </h5>
        <iframe src="/dataDoc" width="100%" height="415px" frameborder="0" scrolling="no"></iframe>
      </div>
    </div>
  </div>
</div>

<script src="/assets/dist/libs/jquery/dist/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
@endsection