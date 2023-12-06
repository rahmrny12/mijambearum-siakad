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

    <div class="position-absolute top-0 bottom-0 left-0 right-0 my-4 bg-light d-none" id="siswa_card" style="height: 100%; width: 100%">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <span id="tanggal_absen">Tanggal : 00 - 00</span>
                <span class="badge badge-success badge-pill py-3 px-4" id="waktu_absen">00:00:00</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between">
                <div class="col-md-6">
                    <div class="my-4">
                        <span class="d-block">Nama Siswa :</span>
                        <span id="nama_siswa">-</span>
                    </div>
                    <div class="my-4">
                        <span class="d-block">Kelas :</span>
                        <span id="kelas">-</span>
                    </div>
                    <div class="my-4">
                        <span class="d-block">Jenis Kelamin :</span>
                        <span id="jenis_kelamin">-</span>
                    </div>
                    <div class="my-4">
                        <span class="d-block">NISN :</span>
                        <span id="nisn">-</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <img class="img-thumbnail img-fluid" src="{{ asset('uploads/siswa/27231912072020_male.jpg') }}" id="foto" alt="Foto Siswa">
                </div>
            </div>
        </div>
    </div>

    <div class="position-absolute top-0 bottom-0 left-0 right-0 my-4 bg-light d-none" id="guru_card" style="height: 100%; width: 100%">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <span id="tanggal_absen">Tanggal : 00 - 00</span>
                <span class="badge badge-success badge-pill py-3 px-4" id="waktu_absen">00:00:00</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between">
                <div class="col-md-6">
                    <div class="my-4">
                        <span class="d-block">Nama Guru :</span>
                        <span id="nama_guru">-</span>
                    </div>
                    <div class="my-4">
                        <span class="d-block">NIP :</span>
                        <span id="nip">-</span>
                    </div>
                    <div class="my-4">
                        <span class="d-block">Jenis Kelamin :</span>
                        <span id="jenis_kelamin">-</span>
                    </div>
                    <div class="my-4">
                        <span class="d-block">Tempat Lahir :</span>
                        <span id="tmp_lahir">-</span>
                    </div>
                    <div class="my-4">
                        <span class="d-block">Tanggal Lahir :</span>
                        <span id="tgl_lahir">-</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <img class="img-thumbnail img-fluid" src="{{ asset('uploads/guru/27231912072020_male.jpg') }}" id="foto" alt="Foto Guru">
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    @yield('script')
    @if (Session::has('success'))
        <script>
            toastr.success("{{ Session('success') }}");
        </script>
    @endif
    @if (Session::has('warning'))
        <script>
            toastr.warning("{{ Session('warning') }}");
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            toastr.error("{{ Session('error') }}");
        </script>
    @endif
</body>

</html>
