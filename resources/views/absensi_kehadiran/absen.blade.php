@extends('layouts.absensi-app')
@section('page', 'MI JAMBEARUM')
@section('content')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <div class="col-md-4">
            <input type="text" class="form-control" placeholder="Masukkan ID Card" id="input-search-siswa" name="keyword" onkeyup="submitAbsen(event, this)" autofocus>
        </div>
    </div>

    @section('script')
        <script>
            function submitAbsen(e, keyword) {
                const isSiswaCardShowing = !$("#siswa_card").hasClass('d-none');
                const isGuruCardShowing = !$("#guru_card").hasClass('d-none');
                if (!isSiswaCardShowing && !isGuruCardShowing) {
                    if (e.key === 'Enter') {
                        searchByRFID(keyword.value)
                            .then(async (result) => {
                                const type = result.hasOwnProperty('nama_guru') ? 'guru' : 'siswa';
                                if (type == 'siswa') {
                                    $('#nama_siswa').html(result.nama_siswa);
                                    $('#kelas').html(result.kelas.nama_kelas);
                                    $('.jenis_kelamin').html(result.jk == "L" ? "Laki-laki" : "Perempuan");
                                    $('#nisn').html(result.nis);
                                    $('#foto').attr('src', `{{ asset('') }}` + result.foto);
                                } else {
                                    $('#nama_guru').html(result.nama_guru);
                                    $('#nip').html(result.nip);
                                    $('.jenis_kelamin').html(result.jk == "L" ? "Laki-laki" : "Perempuan");
                                    $('#tmp_lahir').html(result.tmp_lahir);
                                    $('#tgl_lahir').html(result.tgl_lahir);
                                    console.log(result.foto)
                                    $('#foto_guru').attr('src', `{{ asset('') }}` + result.foto);
                                }
                                
                                await sendAbsensi(keyword)
                                    .then(response => {
                                        const type = response.type;
                                        const message = response.message;

                                        toastr.options.positionClass = "toast-top-center";
                                        if (type == 'success') {
                                            toastr.success(message)
                                        } else if (type == 'warning') {
                                            toastr.warning(message)
                                        } else if (type == 'error') {
                                            toastr.error(message)
                                        }
                                        toastr.options.positionClass = "toast-top-right";
                                    })
                                    .catch(error => {
                                        toastr.error("Terjadi kesalahan saat mengirim absensi. " + error.status == undefined ? '' : error.status + " " + error.statusText == undefined ? '' : error.statusText)
                                    })
                                    .finally(() => {
                                        const removeCard = setTimeout(() => {
                                            $("#siswa_card").addClass('d-none');
                                            $("#guru_card").addClass('d-none');
                                        }, 2000);
                                    })
                            })
                            .catch(error => {
                                if (error.status == 404) {
                                    toastr.error("Data tidak ditemukan.")
                                } else {
                                    console.log(error)
                                    toastr.error("Terjadi kesalahan saat mengambil data. " + error.status + " " + error.statusText)
                                }
                            })
                            .finally(() => {
                                $('#input-search-siswa').val('')
                            })
                    }
                } else {
                    $('#input-search-siswa').val('')
                }
            }
            
            function searchByRFID(keyword) {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "keyword": keyword,
                        },
                        url: "{{ url('/absensi/search') }}",
                        success: function(result){
                            if(Object.keys(result).length != 0){
                                const type = result.hasOwnProperty('nama_guru') ? 'guru' : 'siswa';
                                
                                if (type == 'siswa') {
                                    $("#siswa_card").removeClass('d-none');
                                } else {
                                    $("#guru_card").removeClass('d-none');
                                }
                                
                                let today = new Date();
                                let formattedDate = today.getDate() + '-' + (today.getMonth() + 1) + '-' + today.getFullYear();
                                $('.tanggal_absen').html("Tanggal : " + formattedDate);

                                let formattedTime = today.toLocaleTimeString('en-US', { hour12: false });
                                $('.waktu_absen').html(formattedTime);
                                
                                resolve(result);
                            }
                        },
                        error: function(error){
                            reject(error);
                        },
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
        </script>
    @endsection
@endsection
