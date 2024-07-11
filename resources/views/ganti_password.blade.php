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

    <!-- Core Css -->
    <link id="themeColors" rel="stylesheet" href="/assets/dist/css/style.min.css" />
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <img src="/img/logoAsasta_file.png" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- Preloader -->
    <div class="preloader">
        <img src="/img/logoAsasta_file.png" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100">
            <div class="position-relative z-index-5">
                <div class="row">
                    <div class="col-lg-6 col-xl-6 col-xxl-6">
                        <a href="/" class="text-nowrap logo-img d-block px-4 py-9 w-100">
                            <img src="/img/logoAsasta_file.png" width="180" alt="" />
                        </a>
                        <div class="d-none d-lg-flex align-items-center justify-content-center" style="height: calc(100vh - 80px)">
                            <img src="/assets/dist/images/backgrounds/login-security.svg" alt="" class="img-fluid" width="500" />
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-6 col-xxl-6">
                        <div class="card mb-0 shadow-none rounded-0 min-vh-100 h-100">
                            <div class="d-flex align-items-center w-100 h-100">
                                <div class="card-body">
                                    @if(Session::has('sukses'))
                                    <div class="alert alert-success">
                                        {{ Session::get('sukses') }}
                                    </div>
                                    @endif
                                    <div class="mb-5">
                                        <h2 class="fw-bolder fs-7 mb-3">Lupa Password?</h2>
                                        <p class="mb-0">Bikin password baru di bawah ini.</p>
                                    </div>
                                    <form name="frm_add" id="frm_add" action="{{route('update_gpass')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="password" class="form-label">New Password</label>
                                            <input type="password" class="form-control" id="password" name="password" required />
                                        </div>
                                        <div class="mb-3">
                                            <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                            <input type="password" class="form-control" id="confirmPassword" name="password_confirmation" required />
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100 py-8 mb-3">
                                            Ganti Password
                                        </button>
                                        <a href="/" class="btn btn-light-primary text-primary w-100 py-8">Back to Home</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
</body>

</html>