@extends('layouts.absensi-app')
@section('page', 'MI JAMBEARUM')
@section('content')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <form action="{{ route('absensi-kehadiran.store') }}" class="col-md-4" method="post">
            @csrf
            <input type="text" class="form-control" id="id_card" placeholder="Masukkan ID Card" id="input-search-siswa" name="keyword">
        </form>
    </div>

    @section('script')
        <script>
            function getSiswa(e) {
                $.ajax({
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "keyword": e.value,
                    },
                    url: "{{ url('/absensi/cari-siswa') }}",
                    success: function(result){
                        if(result){
                            $("#siswa-card").removeClass('d-none');
                            
                            $.each(result,function(index, val){
                                $("#judul").text('Edit Data Kelas ' + val.nama);
                                $('#id').val(val.id);
                                $('#form_nama').html('');
                                $('#form_paket').html('');
                                $("#form_paket").append(form_paket);
                                $('#nama_kelas').val(val.nama);
                                $("#paket_id").val(val.paket_id);
                                $('#guru_id').val(val.guru_id);
                            });
                        }
                    },
                    error: function(){
                        $("#siswa-card").addClass('d-none');
                        toastr.error("Errors 404!");
                    },
                    complete: function(){
                    }
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
