@extends('layouts.absensi-app')
@section('page', 'MI JAMBEARUM')
@section('content')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <div class="col-md-4">
            <input type="text" class="form-control" id="id_card" placeholder="Masukkan ID Card" id="input-search-siswa" name="keyword" onkeyup="submitAbsen(event, this)">
        </div>
    </div>

    @section('script')
        <script>
            function submitAbsen(e, keyword) {
                if (e.key === 'Enter') {
                    getSiswa(keyword.value)
                        .then(result => {
                            const type = result.hasOwnProperty('nama_guru') ? 'guru' : 'siswa';
                            if (type == 'siswa') {
                                $('#nama_siswa').html(result.nama_siswa);
                                $('#kelas').html(result.kelas.nama_kelas);
                                $('#jenis_kelamin').html(result.jk == "L" ? "Laki-laki" : "Perempuan");
                                $('#nisn').html(result.nis);
                                $('#foto').attr('src', `{{ asset('') }}` + result.foto);
                            } else {
                                $('#nama_guru').html(result.nama_guru);
                                $('#nip').html(result.nip);
                                $('#jenis_kelamin').html(result.jk == "L" ? "Laki-laki" : "Perempuan");
                                $('#tmp_lahir').html(result.tmp_lahir);
                                $('#tgl_lahir').html(result.tgl_lahir);
                                $('#foto').attr('src', `{{ asset('') }}` + result.foto);
                            }
                            
                            sendAbsensi(keyword)
                                .then(response => {
                                    const type = Object.keys(response)[0];
                                    const message = response[type];

                                    toastr.options.positionClass = "toast-top-center";
                                    if (type == 'success') {
                                        toastr.success(message)
                                    } else if (type == 'warning') {
                                        toastr.warning(message)
                                    } else if (type == 'error') {
                                        toastr.error(message)
                                    }
                                    toastr.options.positionClass = "toast-top-right";
                                    
                                    setInterval(() => {
                                        if (type == 'siswa') {
                                            $("#siswa_card").addClass('d-none');
                                        } else {
                                            $("#guru_card").addClass('d-none');
                                        }
                                    }, 5000);
                                })
                                .catch(error => {
                                    console.log(error)
                                    toastr.error("Terjadi kesalahan saat mengirim absensi. " + error.status ?? '' + " " + error.statusText ?? '')
                                })
                        })
                        .catch(error => {
                            console.log(error)
                            toastr.error("Terjadi kesalahan saat mengambil data. " + error.status + " " + error.statusText)
                        })
                    // setTimeout(function() {
                    //     $('#siswa-card');
                    // }, 2000); // 2000 milliseconds = 2 seconds
                }
            }
            
            function getSiswa(keyword) {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "keyword": keyword,
                        },
                        url: "{{ url('/absensi/cari-siswa') }}",
                        success: function(result){
                            if(result){
                                const type = result.hasOwnProperty('nama_guru') ? 'guru' : 'siswa';
                                
                                if (type == 'siswa') {
                                    $("#siswa_card").removeClass('d-none');
                                } else {
                                    $("#guru_card").removeClass('d-none');
                                }
                                
                                let today = new Date();
                                let formattedDate = today.getDate() + '-' + (today.getMonth() + 1) + '-' + today.getFullYear();
                                $('#tanggal_absen').html("Tanggal : " + formattedDate);

                                let formattedTime = today.toLocaleTimeString('en-US', { hour12: false });
                                $('#waktu_absen').html(formattedTime);
                                
                                resolve(result);
                            }
                        },
                        error: function(error){
                            $("#siswa-card").addClass('d-none');
                            reject(error);
                        },
                        complete: function(){
                        }
                    });
                });
            }

            function sendAbsensi(e) {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "keyword": e.value,
                        },
                        url: "{{ url('/absensi-kehadiran') }}",
                        success: function(result){
                            resolve(result);
                        },
                        error: function(error){
                            reject(error);
                        },
                        complete: function(){
                        }
                    });
                });
            }
            
            function delay(callback, ms) {
                var timer = 0;
                return function() {
                    var context = this, args = arguments;
                    clearTimeout(timer);
                    timer = setTimeout(function () {
                    callback.apply(context, args);
                    }, ms || 0);
                };
            }
        </script>
    @endsection
@endsection
