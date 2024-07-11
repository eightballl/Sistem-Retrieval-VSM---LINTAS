<!DOCTYPE html>
<html lang="en">

<head>
    <!--  Title -->
    <title>Login - LINTAS</title>
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
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-4">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="/" class="text-nowrap logo-img text-center d-block mb-5 w-100">
                                    <img src="/img/logoAsasta_file.png" width="180" alt="" />
                                </a>
                                @if(session('error'))
                                <div class="alert alertku alert-danger">
                                    <b>Opps!</b> {{session('error')}}
                                </div>
                                @endif
                                <form action="{{ route('actionlogin') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Username</label>
                                        <input type="text" class="form-control" name="username" id="exampleInputEmail1" aria-describedby="emailHelp" />
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" id="exampleInputPassword1" />
                                    </div>
                                    <button class="btn btn-primary w-100 py-8 mb-4 rounded-2">SIGN IN</button>
                                </form>
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
    <script>
        $(document).ready(function() {
            // Alert
            $(".alertku").delay(1000)
                .fadeIn()
                .delay(3000)
                .fadeOut();
        });
    </script>
</body>

</html>