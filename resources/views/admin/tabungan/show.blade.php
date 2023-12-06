@extends('template_backend.home')
@section('heading', 'Daftar Siswa')
@section('page')
    <li class="breadcrumb-item active">Daftar Siswa</li>
@endsection
@section('content')
    <div class="ml-2 mb-3">
        <a href="{{ route('kelas.tabungan.index') }}" class="btn btn-default"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</a> &nbsp;
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Siswa</th>
                            <th>Saldo</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswa as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nama_siswa }}</td>
                                <td>{{ 'Rp. ' . number_format($data->tabungan->saldo, 0, ',', '.') }}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#tambah-tabungan-{{ $data->id }}">
                                        Menabung
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#tarik-tabungan-{{ $data->id }}">
                                        Tarik
                                    </button>
                                    <a href="{{ route('tabungan.show', $data->id) }}"
                                        class="btn btn-info btn-sm"><i class="nav-icon fas fa-search-plus"></i> &nbsp;
                                        Riwayat
                                    </a>
                                </td>
                            </tr>

                            <div class="modal" id="tambah-tabungan-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Tabungan {{ $data->nama_siswa }}</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('tabungan.store') }}" method="post" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="hidden" name="siswa_id" value="{{ $data->id }}">
                                                        <input type="hidden" name="jenis_tabungan" value="menabung">
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

                            <div class="modal" id="tarik-tabungan-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Tarik Tabungan {{ $data->nama_siswa }}</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('tabungan.store') }}" method="post" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="hidden" name="siswa_id" value="{{ $data->id }}">
                                                        <input type="hidden" name="jenis_tabungan" value="menarik">
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
