@extends('template_backend.home')
@section('heading', 'Absensi Kehadiran Siswa')
@section('page')
    <li class="breadcrumb-item active">Absensi Kehadiran Siswa</li>
@endsection
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="get">
                    <div class="d-flex justify-content-between">
                        <div class="mb-3 col-md-3 px-0">
                            <select id="guru" type="text" class="form-control select2bs4" name="guru"
                                autocomplete="guru" onchange="getMapelGuru()">
                                <option value="">Pilih Kelas</option>
                                {{-- @foreach ($guru as $item)
                                    <option @if (request('guru') == $item->id) selected @endif value="{{ $item->id }}">
                                        {{ $item->nama_guru }}
                                    </option>
                                @endforeach --}}
                            </select>
                        </div>
                </form>
            </div>
            <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Foto Siswa</th>
                        <th>Nama Siswa</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($absensi_kehadiran as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->tanggal }}</td>
                            <td>
                                <a href="{{ asset($data->siswa->foto) }}" data-toggle="lightbox" data-title="Foto {{ $data->siswa->nama_siswa }}" data-gallery="gallery">
                                    <img src="{{ asset($data->siswa->foto) }}" width="130px" class="img-fluid mb-2">
                                </a>
                            </td>
                            <td>{{ $data->siswa->nama_siswa }}</td>
                            <td>{{ $data->jam_masuk }}</td>
                            <td>{{ $data->jam_pulang ?? '-' }}</td>
                            <td>{{ $data->status_masuk }}</td>
                            <td class="d-flex">
                                <form action="{{ route('absensi-kehadiran.destroy-siswa', $data->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm"><i class="nav-icon fas fa-trash-alt"></i>
                                        &nbsp; Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    </div>
    <!-- /.col -->

@endsection
@section('script')
    <script>
        $("#DataModul").addClass("active");

        $("document").ready(function() {
            getMapelGuru();
        })

        function getMapelGuru() {
            let guru = document.getElementById('guru');
            let mapel = document.getElementById('mapel');

            if (!guru.value)
                return;

            $.ajax({
                type: "GET",
                dataType: "JSON",
                url: `{{ url('/modul-guru/get-mapel-guru/${guru.value}') }}`,
                success: function(result) {
                    if (result) {
                        $('#mapel').empty();
                        var option = $('<option value="">-- Pilih Mapel --</option>');
                        $('#mapel').append(option);
                        if (result) {
                            $.each(result, function(index, val) {
                                var option = $('<option></option>')
                                    .attr('value', val.id).text(
                                        val
                                        .nama_mapel)
                                    .prop('selected', ("{{ request('mapel') }}" == val.id));
                                $('#mapel').append(option);
                            });
                        }
                    } else {
                        toastr.error("Gagal mengambil data mapel.");
                    }
                },
                error: function(e) {
                    toastr.error("Terjadi kesalahan. Coba lagi nanti.");
                },
                complete: function() {}
            });
        }
    </script>
@endsection
