<!-- Owl Carousel  -->
<link rel="stylesheet" href="/assets/dist/libs/owl.carousel/dist/assets/owl.carousel.min.css" />

<!-- Core Css -->
<link id="themeColors" rel="stylesheet" href="/assets/dist/css/style.min.css" />
<div class="d-flex align-items-center justify-content-between mb-4">
    <h5 class="card-title mb-0 fw-semibold">
        <!-- Data Surat -->
    </h5>
    <div>
        <form action="/dataDoc">
            <!-- <label class="form-label">Tahun Surat</label> -->
            <select class="form-select text-dark" name="tahun" id="selectTahun">
                <?php

                use Carbon\Carbon;

                $tahunSekarang = Carbon::now()->year;
                for ($tahun = 2011; $tahun <= $tahunSekarang; $tahun++) {
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
        <span>Jumlah Dokumen</span>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Menambahkan event listener untuk mendeteksi perubahan pada elemen select
    document.getElementById('selectTahun').addEventListener('change', function() {
        // Mengirimkan formulir saat terjadi perubahan pada elemen select
        this.form.submit();
    });

    $(function() {
        // =====================================
        // Diagram Dokumen
        // =====================================
        var options = {
            series: [{
                name: "Jumlah Dokumen",
                data: [<?php
                        foreach ($chartDocCount as $Doc) {
                            echo '"' . $Doc->jumlah_dokumen . '",';
                        } ?>],
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
                    foreach ($chartDocCount as $masuk) {
                        echo '["' . $Doc->bulan . '"],';
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
<!--  Import Js Files -->
<script src="/assets/dist/libs/jquery/dist/jquery.min.js"></script>
<script src="/assets/dist/libs/simplebar/dist/simplebar.min.js"></script>
<script src="/assets/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!--  core files -->
<script src="/assets/dist/js/app.min.js"></script>
<script src="/assets/dist/js/app.init.js"></script>
<script src="/assets/dist/js/app-style-switcher.js"></script>
<script src="/assets/dist/js/sidebarmenu.js"></script>
<script src="/assets/dist/js/custom.js"></script>
<!--  current page js files -->
<script src="/assets/dist/libs/owl.carousel/dist/owl.carousel.min.js"></script>
<script src="/assets/dist/libs/apexcharts/dist/apexcharts.min.js"></script>
<script src="/assets/dist/js/dashboard.js"></script>
<script src="/assets/dist/js/apps/chat.js"></script>
<script src="/assets/dist/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/assets/dist/js/datatable/datatable-basic.init.js"></script>