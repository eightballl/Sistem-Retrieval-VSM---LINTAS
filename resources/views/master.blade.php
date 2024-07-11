<!DOCTYPE html>
<html lang="en">

<head>
    <!--  Title -->
    <title>LINTAS</title>
    <!--  Required Meta Tag -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="Mordenize" />
    <meta name="author" content="" />
    <meta name="keywords" content="Mordenize" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--  Favicon -->
    <link rel="shortcut icon" type="image/png" href="/img/logoAsasta_file.png" />
    <!-- Owl Carousel  -->
    <link rel="stylesheet" href="/assets/dist/libs/owl.carousel/dist/assets/owl.carousel.min.css" />

    <!-- Core Css -->
    <link id="themeColors" rel="stylesheet" href="/assets/dist/css/style.min.css" />

    <!-- Sweet Alert -->
    <link href="/assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css">
    <link href="/assets/dist/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <!-- <link id="themeColors" rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" /> -->
    <link id="themeColors" rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" />
</head>

<body>
    <?php

    use App\Models\Disposisi;
    use App\Models\Divisi;
    use App\Models\Kategori;
    use App\Models\Surat;

    $kategoriii = Kategori::all();
    $divisiii = Divisi::all();

    $divisiSelect = Divisi::where('id', Auth::user()->id_divisi)->select('id')->first();
    $divisiID = $divisiSelect->id;

    $namaUser = Auth::user()->name;
    $role = Auth::user()->role;
    $jabatan = Auth::user()->jabatan->nm_jabatan ?? 'Superadmin';
    $divisi = Auth::user()->divisi->nama_divisi ?? 'Superadmin';
    $totalOn = Surat::where(function ($query) {
        $user = Auth::user();

        $query->where('id_penerima', $user->id_divisi)
            ->orWhere('id_pengirim', $user->id_divisi);
    })
        ->whereNotIn('status_surat', [3])
        ->count();

    $total = Surat::where(function ($query) {
        $user = Auth::user();

        $query->where('id_penerima', $user->id_divisi)
            ->orWhere('id_pengirim', $user->id_divisi);
    })
        ->whereIn('status_surat', [3])
        ->count();

    $totalAll = Surat::where(function ($query) {
        $user = Auth::user();

        $query->where('id_penerima', $user->id_divisi)
            ->orWhere('id_pengirim', $user->id_divisi);
    })
        ->count();

    $totalOnDis1 = Disposisi::join('surat', 'disposisi.id_surat', '=', 'surat.id')
        ->where('disposisi.id_pegawai', Auth::user()->id)
        ->whereNotIn('surat.status_disposisi', [3])
        ->orderBy('disposisi.created_at', 'desc')
        ->limit(5)
        ->get();

    $totalOnDis = Disposisi::join('surat', 'disposisi.id_surat', '=', 'surat.id')
        ->where('disposisi.id_pegawai', Auth::user()->id)
        ->whereNotIn('surat.status_disposisi', [3])
        ->count();

    $totalDisMas = Disposisi::join('surat', 'disposisi.id_surat', '=', 'surat.id')
        ->where('disposisi.id_pegawai', Auth::user()->id)
        ->where('surat.id_kategori', 1)
        ->whereIn('surat.status_disposisi', [3])
        ->count();

    $totalAllDisMas = Disposisi::join('surat', 'disposisi.id_surat', '=', 'surat.id')
        ->where('disposisi.id_pegawai', Auth::user()->id)
        ->where('surat.id_kategori', 1)
        ->count();

    $totalOnDisMas = Disposisi::join('surat', 'disposisi.id_surat', '=', 'surat.id')
        ->where('disposisi.id_pegawai', Auth::user()->id)
        ->where('surat.id_kategori', 1)
        ->whereNotIn('surat.status_disposisi', [3])
        ->count();

    $totalOnDisKel = Disposisi::join('surat', 'disposisi.id_surat', '=', 'surat.id')
        ->where('disposisi.id_pegawai', Auth::user()->id)
        ->where('surat.id_kategori', 2)
        ->whereNotIn('surat.status_disposisi', [3])
        ->count();

    $totalDisKel = Disposisi::join('surat', 'disposisi.id_surat', '=', 'surat.id')
        ->where('disposisi.id_pegawai', Auth::user()->id)
        ->where('surat.id_kategori', 2)
        ->whereIn('surat.status_disposisi', [3])
        ->count();

    $totalAllDisKel = Disposisi::join('surat', 'disposisi.id_surat', '=', 'surat.id')
        ->where('disposisi.id_pegawai', Auth::user()->id)
        ->where('surat.id_kategori', 2)
        ->count();

    $totalmanager1 = Surat::where('status', [1])
        ->limit(5)
        ->orderby('created_at', 'desc')
        ->get();
    $totalmanagerMasuk = Surat::where('status_disposisi', [0])->where('id_kategori', 1)->count();
    $totalmanagerKeluar = Surat::where('status_disposisi', [0])->where('id_kategori', 2)->count();
    $totalspv1 = Surat::where('status', [2])
        ->get();
    $totalspv = Surat::where('status', [2])->count();
    $admintotal = $totalspv + $totalOnDis;
    ?>
    <!-- Preloader -->
    <div class="preloader">
        <img src="/img/logoAsasta_file.png" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- Preloader -->
    <div class="preloader">
        <img src="/img/logoAsasta_file.png" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-theme="blue_theme" data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="/" class="text-nowrap logo-img">
                        <img src="/img/logoAsasta_file.png" class="dark-logo" width="210" alt="" />
                        <img src="/img/logoAsasta_file.png" class="light-logo" width="210" alt="" />
                    </a>
                    <div class="close-btn d-lg-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8 text-muted"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar>
                    <ul id="sidebarnav">
                        <!-- ============================= -->
                        <!-- Home -->
                        <!-- ============================= -->
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Home</span>
                        </li>
                        <!-- =================== -->
                        <!-- Dashboard -->
                        <!-- =================== -->
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/home" aria-expanded="false">
                                <span>
                                    <i class="ti ti-aperture"></i>
                                </span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <!-- ============================= -->
                        <!-- Data Master -->
                        <!-- ============================= -->
                        <!-- <li class="nav-small-cap">
                            <i class="ti ti-pencil nav-small-cap-icon fs-4"></i>
                            <button type="button" class="hide-menu btn btn-info btn-rounded m-t-10 mb-2" data-bs-toggle="modal" data-bs-target="#tambahSurat">
                                <i class="fs-4 ti ti-pencil"></i> Tulis Surat
                            </button>
                        </li> -->

                        <!-- UPLOAD DOKUMEN -->
                        <!-- @if (Route::is('home', 'disposisi', 'surat_keluar', 'status_surat', 'riwayat', 'surat'))
                        <li class="nav-small-cap">
                            <i class="ti ti-pencil nav-small-cap-icon fs-4"></i>
                            <button type="button" class="hide-menu btn btn-info btn-rounded m-t-10 mb-2" data-bs-toggle="modal" data-bs-target="#tambahSurat">
                                <i class="fs-4 ti ti-pencil"></i> Tulis Surat
                            </button>
                        </li>
                        @endif -->

                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Master</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/arsipdokumen" aria-expanded="false">
                                <span>
                                    <i class="ti ti-files"></i>
                                </span>
                                <span class="hide-menu">Arsip Dokumen</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Pencarian</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/searchdokumen" aria-expanded="false">
                                <span>
                                    <i class="ti ti-file-search"></i>
                                </span>
                                <span class="hide-menu">Pencarian Dokumen</span>
                            </a>
                        </li>
                        <!-- <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Management</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/surat/masuk" aria-expanded="false">
                                <span>
                                    <i class="ti ti-file-spreadsheet"></i>
                                </span>
                                <span class="hide-menu">Management Dokumen</span>
                            </a>
                        </li> -->

                        <!-- LINTAS -->

                        <!-- <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Surat</span>
                        </li>
                        @if ($role == 1)
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/divisi" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-layout"></i>
                                </span>
                                <span class="hide-menu">Divisi</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/jabatan" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-id-badge"></i>
                                </span>
                                <span class="hide-menu">Jabatan</span>
                            </a>
                        </li>
                        @endif

                        @if ($role == 1|| $role == 3 || $role == 4)
                        @if ($totalDisMas == $totalAllDisMas)
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/surat/masuk" aria-expanded="false">
                                <span>
                                    <i class="ti ti-file-arrow-right"></i>
                                </span>
                                <span class="hide-menu">Surat Masuk</span>
                            </a>
                        </li>
                        @else
                        <li class="sidebar-item">
                            <a class="sidebar-link justify-content-between" href="/surat/masuk" aria-expanded="false">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="d-flex">
                                        <i class="ti ti-file-arrow-right"></i>
                                    </span>
                                    <span class="hide-menu">Surat Masuk</span>
                                </div>
                                <div class="hide-menu">
                                    <span class="badge rounded-circle bg-primary d-flex align-items-center justify-content-center round-20 p-0">{{$totalOnDisMas}}</span>
                                </div>
                            </a>
                        </li>
                        @endif
                        @elseif ($role == 2)
                        @if ($totalmanagerMasuk == 0)
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/surat/masuk" aria-expanded="false">
                                <span>
                                    <i class="ti ti-file-arrow-right"></i>
                                </span>
                                <span class="hide-menu">Surat Masuk</span>
                            </a>
                        </li>
                        @else
                        <li class="sidebar-item">
                            <a class="sidebar-link justify-content-between" href="/surat/masuk" aria-expanded="false">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="d-flex">
                                        <i class="ti ti-file-arrow-right"></i>
                                    </span>
                                    <span class="hide-menu">Surat Masuk</span>
                                </div>
                                <div class="hide-menu">
                                    <span class="badge rounded-circle bg-primary d-flex align-items-center justify-content-center round-20 p-0">{{$totalmanagerMasuk}}</span>
                                </div>
                            </a>
                        </li>
                        @endif
                        @endif

                        @if ($role == 1 || $role == 3 || $role == 4)
                        @if ($totalDisKel == $totalAllDisKel)
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/surat/keluar" aria-expanded="false">
                                <span>
                                    <i class="ti ti-file-arrow-left"></i>
                                </span>
                                <span class="hide-menu">Surat Keluar</span>
                            </a>
                        </li>
                        @else
                        <li class="sidebar-item">
                            <a class="sidebar-link justify-content-between" href="/surat/keluar" aria-expanded="false">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="d-flex">
                                        <i class="ti ti-file-arrow-left"></i>
                                    </span>
                                    <span class="hide-menu">Surat Keluar</span>
                                </div>
                                <div class="hide-menu">
                                    <span class="badge rounded-circle bg-primary d-flex align-items-center justify-content-center round-20 p-0">{{$totalOnDisKel}}</span>
                                </div>
                            </a>
                        </li>
                        @endif
                        @elseif ($role == 2)
                        @if ($totalmanagerKeluar == 0)
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/surat/keluar" aria-expanded="false">
                                <span>
                                    <i class="ti ti-file-arrow-left"></i>
                                </span>
                                <span class="hide-menu">Surat Keluar</span>
                            </a>
                        </li>
                        @else
                        <li class="sidebar-item">
                            <a class="sidebar-link justify-content-between" href="/surat/keluar" aria-expanded="false">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="d-flex">
                                        <i class="ti ti-file-arrow-left"></i>
                                    </span>
                                    <span class="hide-menu">Surat Keluar</span>
                                </div>
                                <div class="hide-menu">
                                    <span class="badge rounded-circle bg-primary d-flex align-items-center justify-content-center round-20 p-0">{{$totalmanagerKeluar}}</span>
                                </div>
                            </a>
                        </li>
                        @endif
                        @endif


                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Status Surat</span>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/surat/status" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-file-time"></i>
                                </span>
                                <span class="hide-menu">Surat Pending</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/surat/riwayat" aria-expanded="false">
                                <span>
                                    <i class="ti ti-file-check"></i>
                                </span>
                                <span class="hide-menu">Surat Selesai</span>
                            </a>
                        </li>


                        @if ($role == 1)
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Account</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/user" aria-expanded="false">
                                <span>
                                    <i class="ti ti-user-circle"></i>
                                </span>
                                <span class="hide-menu">Pegawai</span>
                            </a>
                        </li>
                        @endif -->
                    </ul>
                    <br />
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link sidebartoggler nav-icon-hover ms-n3" id="headerCollapse" href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="d-block d-lg-none">
                        <img src="/img/logoAsasta_file.png" class="dark-logo" width="180" alt="" />
                        <img src="/img/logoAsasta_file.png" class="light-logo" width="180" alt="" />
                    </div>
                    <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="p-2">
                            <!-- <i class="ti ti-dots fs-7"></i> -->
                            <div class="user-profile-img">
                                <img src="/assets/dist/images/profile/user-1.jpg" class="rounded-circle" width="35" height="35" alt="" />
                            </div>
                        </span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                        <div class="d-flex align-items-center justify-content-between">
                            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                                <!-- <li class="nav-item dropdown">
                                    @if ($role == 4)
                                    @if ($totalDisMas == $totalAllDisMas)
                                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-bell-ringing"></i>
                                    </a>
                                    @else
                                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-bell-ringing"></i>
                                        <div class="notification bg-primary rounded-circle"></div>
                                    </a>
                                    @endif
                                    @endif
                                    @if ($role == 2)
                                    @if ($totalmanagerMasuk == 0)
                                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-bell-ringing"></i>
                                    </a>
                                    @else
                                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-bell-ringing"></i>
                                        <div class="notification bg-primary rounded-circle"></div>
                                    </a>
                                    @endif
                                    @endif
                                    @if ($role == 3)
                                    @if ($totalspv == 0)
                                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-bell-ringing"></i>
                                    </a>
                                    @else
                                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-bell-ringing"></i>
                                        <div class="notification bg-primary rounded-circle"></div>
                                    </a>
                                    @endif
                                    @endif
                                    <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                                        <div class="d-flex align-items-center justify-content-between py-3 px-7">
                                            <h5 class="mb-0 fs-5 fw-semibold">Notifications</h5>
                                            <span class="badge bg-primary rounded-4 px-3 py-1 lh-sm">
                                                @if ($role == 1)
                                                {{$admintotal}} New
                                                @elseif ($role == 2)
                                                {{$totalmanagerMasuk}} New
                                                @elseif ($role == 3)
                                                {{$totalOnDis}} New
                                                @elseif ($role == 4)
                                                {{$totalOnDis}} New
                                                @endif
                                            </span>
                                        </div>
                                        <div class="message-body" data-simplebar>
                                            @if ($role == 2)
                                            @foreach ($totalmanager1 as $surat)
                                            <a href="/surat" class="py-6 px-7 d-flex align-items-center dropdown-item">
                                                <div class="w-75 d-inline-block v-middle">
                                                    <h6 class="mb-1 fw-semibold">
                                                        {{$surat->no_surat}}
                                                    </h6>
                                                    <span class="d-block">
                                                        Menunggu disposisi Manager
                                                    </span>
                                                </div>
                                            </a>
                                            @endforeach
                                            @elseif ($role == 3 || $role == 4)
                                            @foreach ($totalOnDis1 as $p)
                                            <a href="/disposisi" class="py-6 px-7 d-flex align-items-center dropdown-item">
                                                <div class="w-75 d-inline-block v-middle">
                                                    <h6 class="mb-1 fw-semibold">
                                                        {{$p->surat->no_surat}}
                                                    </h6>
                                                    <span class="d-block">{{$p->surat->perihal}}</span>
                                                </div>
                                            </a>
                                            @endforeach
                                            @endif
                                        </div>
                                        @if ($role == 2)
                                        <div class="py-6 px-7 mb-1">
                                            <a href="/surat" class="btn btn-outline-primary w-100">
                                                See All Notifications
                                            </a>
                                        </div>
                                        @elseif ($role == 3 || $role == 4)
                                        <div class="py-6 px-7 mb-1">
                                            <a href="/disposisi" class="btn btn-outline-primary w-100">
                                                See All Notifications
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </li> -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <div class="user-profile-img">
                                                <img src="/assets/dist/images/svgs/icon-account.svg" class="rounded-circle" width="35" height="35" alt="" />
                                            </div>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
                                        <div class="profile-dropdown position-relative" data-simplebar>
                                            <div class="py-3 px-7 pb-0">
                                                <h5 class="mb-0 fs-5 fw-semibold">User Profile</h5>
                                            </div>
                                            <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                                <img src="/assets/dist/images/svgs/icon-account.svg" class="rounded-circle" width="80" height="80" alt="" />
                                                <!-- <img src="/assets/dist/images/profile/user-1.jpg" class="rounded-circle" width="80" height="80" alt="" /> -->
                                                <div class="ms-3">
                                                    <h5 class="mb-1 fs-3">{{$namaUser}}</h5>
                                                    <span class="mb-1 d-block text-dark">{{$jabatan}}</span>
                                                    <p class="mb-0 d-flex text-dark align-items-center gap-2">
                                                        <i class="ti ti-layout"></i> {{$divisi}}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="message-body">
                                                <a href="/gpass" class="py-8 px-7 mt-8 d-flex align-items-center">
                                                    <span class="d-flex align-items-center justify-content-center bg-light rounded-1 p-6">
                                                        <img src="/assets/dist/images/svgs/icon-account.svg" alt="" width="24" height="24" />
                                                    </span>
                                                    <div class="w-75 d-inline-block v-middle ps-3">
                                                        <h6 class="mb-1 bg-hover-primary fw-semibold">
                                                            My Profile
                                                        </h6>
                                                        <span class="d-block text-dark">Ganti Password</span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="d-grid py-4 px-7 pt-8">
                                                <a href="{{route('actionlogout')}}" class="btn btn-outline-primary">Log Out</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <!--  Header End -->
            <div class="container-fluid">
                <!-- KONTEN -->
                <!-- Start Modal Tambah Surat -->
                @if (Route::is('home', 'disposisi', 'surat_keluar', 'status_surat', 'riwayat', 'surat'))
                <div id="tambahSurat" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <div class="modal-header d-flex align-items-center">
                                <h4 class="modal-title" id="myModalLabel">
                                    Tulis Surat
                                </h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form name="frm_add" id="frm_add" action="/simpansurat" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="no_surat" id="suratLabel" placeholder="No. Surat" required />
                                            <label for="suratLabel"><i class="ti ti-file-text"></i> No. Surat</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="perihal" id="perihalLabel" placeholder="Perihal" required />
                                            <label for="perihalLabel"><i class="ti ti-file-text"></i> Perihal</label>
                                        </div>
                                        <!-- <div class="form-floating mb-3">
                                            <select class="form-select col-12" name="jenis_surat" id="jsLabel" onchange="myFunction(pp)" required>
                                                <option value="">-- Jenis Surat --</option>
                                                @foreach($kategoriii as $k)
                                                <option value="{{$k->id}}">{{$k->nama}}</option>
                                                @endforeach
                                            </select>
                                            <label for="jsLabel"><i class="ti ti-file-text"></i> Jenis Surat</label>
                                        </div> -->
                                        <div class="form-floating mb-3">
                                            <select class="form-select col-12" name="pengirim" id="pengirimJS" required>
                                                <option value="">-- Pilih Divisi --</option>
                                                @foreach($divisiii as $d)
                                                <option value="{{$d->id}}"> {{$d->nama_divisi}} </option>
                                                @endforeach
                                            </select>
                                            <label><i class="ti ti-layout"></i> Pengirim</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select col-12" name="penerima" id="penerimaJS" required>
                                                <option value="">-- Pilih Divisi --</option>
                                                @foreach($divisiii as $d)
                                                <option value="{{$d->id}}"> {{$d->nama_divisi}} </option>
                                                @endforeach
                                            </select>
                                            <label><i class="ti ti-layout"></i> Penerima</label>
                                        </div>
                                        <span id="fileText" style="display: none;">Pertinjau File</span>
                                        <iframe id="fileSurat" style="width: 100%; height: 350px; display: none;"></iframe>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" type="file" name="file" id="formFile" accept="application/pdf,image/*" onchange="readURL(this);" />
                                            <label><i class="ti ti-file"></i> Upload Surat</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-info">
                                            <i class="ti ti-device-floppy me-1 fs-4"></i> Simpan
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
                @endif

                <!-- End Modal Tambah Surat -->
                @yield('konten')
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @if (Route::is('home', 'disposisi', 'surat_keluar', 'status_surat', 'riwayat', 'surat'))
    <script>
        function readURL(input) {
            var fileSurat = document.getElementById('fileSurat');
            var fileText = document.getElementById('fileText');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    // Set the source of the iframe to the data URL of the selected file
                    fileSurat.src = e.target.result;

                    // Show the iframe
                    fileSurat.style.display = 'block';
                    fileText.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                // Hide the iframe if no file is selected
                fileSurat.style.display = 'none';
                fileText.style.display = 'none';
            }
        };
    </script>
    @endif

    <script>
        document.body.onchange = function(pp) {
            var element = event.target;

            if (element.id === "jsLabel") {
                var selectedValue = element.value;

                if (selectedValue === "1") {
                    document.getElementById("pengirimJS").value = "";
                    document.getElementById("penerimaJS").value = "{{$divisiID}}";
                } else if (selectedValue === "2") {
                    document.getElementById("penerimaJS").value = "";
                    document.getElementById("pengirimJS").value = "{{$divisiID}}";
                }
            }
        };
        $(document).ready(function() {
            // Alert
            $(".alertku").delay()
                .fadeIn()
                .delay(3000)
                .fadeOut();

            $('#tabel1').DataTable({
                "order": [], // Sort the first column (index 0) in descending order
                "bDestroy": true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            });

            $('#zero_config').DataTable({
                "order": [], // Sort the first column (index 0) in descending order
                "bDestroy": true,
                pageLength: 8,
                lengthMenu: [
                    [8],
                    [8]
                ]
            });

            $('#zero_config1').DataTable({
                "order": [4, 'asc'], // Sort the first column (index 0) in descending order
                "bDestroy": true
            });

            $('#zero_config2').DataTable({
                "order": [4, 'asc'], // Sort the first column (index 0) in descending order
                "bDestroy": true
            });

            $('#zero_config3').DataTable({
                "order": [4, 'desc'], // Sort the first column (index 0) in descending order
                "bDestroy": true
            });

            $('#zero_config4').DataTable({
                "order": [4, 'asc'], // Sort the first column (index 0) in descending order
                "bDestroy": true
            });

            $('#zero_config5').DataTable({
                "order": [4, 'asc'], // Sort the first column (index 0) in descending order
                "bDestroy": true
            });
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
    <!-- SWEET ALERT -->
    <script src="/assets/plugins/bootstrap-sweetalert/sweet-alert.min.js"></script>
    <script src="/assets/pages/sweet-alert.init.js"></script>
    <!-- Datatables-->
    <script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="/assets/plugins/datatables/buttons.bootstrap.min.js"></script>
    <script src="/assets/plugins/datatables/jszip.min.js"></script>
    <script src="/assets/plugins/datatables/pdfmake.min.js"></script>
    <script src="/assets/plugins/datatables/vfs_fonts.js"></script>
    <script src="/assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="/assets/plugins/datatables/buttons.print.min.js"></script>
</body>

</html>