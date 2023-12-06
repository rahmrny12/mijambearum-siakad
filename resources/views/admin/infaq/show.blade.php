@extends('template_backend.home')
@section('heading', 'Daftar Siswa')
@section('page')
    <li class="breadcrumb-item active">Daftar Siswa</li>
@endsection
@section('content')
    <div class="ml-2 mb-3">
        <a href="{{ route('kelas.infaq.index') }}" class="btn btn-default"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</a> &nbsp;
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Siswa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswa as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nama_siswa }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#tambah-infaq-{{ $data->id }}">
                                        Infaq
                                    </button>
                                    <a href="{{ route('infaq.show', $data->id) }}"
                                        class="btn btn-info btn-sm"><i class="nav-icon fas fa-search-plus"></i> &nbsp;
                                        Riwayat
                                    </a>
                                </td>
                            </tr>

                            <div class="modal" id="tambah-infaq-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Infaq {{ $data->nama_siswa }}</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('infaq.store') }}" method="post" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="hidden" name="siswa_id" value="{{ $data->id }}">
                                                        <div class="form-group">
                                                            <label for="nominal">Nominal</label>
                                                            <input type="text" id="nominal" name="nominal"
                                                                class="form-control @error('nominal') is-invalid @enderror" placeholder="nominal">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                                        class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</button>
                                                <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp;
                                                    Simpan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $("#MasterData").addClass("active");
        $("#liMasterData").addClass("menu-open");
        $("#DataJadwal").addClass("active");
        $("#jam_mulai,#jam_selesai").timepicker({
            timeFormat: 'HH:mm'
        });
    </script>
@endsection
