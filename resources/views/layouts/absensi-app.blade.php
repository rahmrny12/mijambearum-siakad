<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sistem Manajemen MI Jambearum</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="shrotcut icon" href="{{ asset('img/favicon.ico') }}">

    <style>
        .login-box:before {
            content: ' ';
            display: block;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            opacity: 0.4;
            background-image: url('{{ asset('img/bg-mijambearum.jpeg') }}');
            background-repeat: no-repeat;
            background-position: 50% 0;
            background-size: cover;
            }
    </style>
</head>

<body class="hold-transition overflow-hidden position-relative login-page">
    <div class="login-box" style="background-color: black; width: 100%; height: 100%;">
        <div class="login-logo my-4">
            <h1 class="text-white">Absensi Kehadiran<br/>MI Jambearum</h1>
        </div>

        @yield('content')

        <footer style="color: white;" class="my-5">
            <marquee>
                <strong>Copyright &copy;
                    <script>
                        document.write(new Date().getFullYear());
                    </script> &diams; <a href="http://piramidsoft.com/" style="color: white;">MI Jambearum</a>.
                </strong>
            </marquee>
        </footer>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    @yield('script')
</body>

</html>
