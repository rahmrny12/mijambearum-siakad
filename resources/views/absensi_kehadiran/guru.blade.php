@extends('template_backend.home')
@section('heading', 'Absensi Kehadiran Guru')
@section('page')
    <li class="breadcrumb-item active">Absensi Kehadiran Guru</li>
@endsection
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="get">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('absensi-kehadiran.guru.export-excel') }}" class="btn btn-success btn-sm my-3" target="_blank"><i
                            class="nav-icon fas fa-file-export"></i> &nbsp; EXPORT EXCEL</a>
                </form>
            </div>
            <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Foto guru</th>
                        <th>Nama guru</th>
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
                                <a href="{{ asset($data->guru->foto) }}" data-toggle="lightbox" data-title="Foto {{ $data->guru->nama_guru }}" data-gallery="gallery">
                                    <img src="{{ asset($data->guru->foto) }}" width="130px" class="img-fluid mb-2">
                                </a>
                            </td>
                            <td>{{ $data->guru->nama_guru }}</td>
                            <td>{{ $data->jam_masuk }}</td>
                            <td>{{ $data->jam_pulang ?? '-' }}</td>
                            <td>{{ $data->status_masuk }}</td>
                            <td class="d-flex">
                                <form action="{{ route('absensi-kehadiran.destroy-guru', $data->id) }}" method="post" id="deleteForm">
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
        $("document").ready(function() {
            document.getElementById('deleteForm').addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Data absensi terkait akan dihapus.",
                    showCancelButton: true,
                    confirmButtonText: "Hapus",
                }).then((result) => {
                    if (result.value) {
                        this.submit()
                    }
                });
            });
        })
    </script>
@endsection
