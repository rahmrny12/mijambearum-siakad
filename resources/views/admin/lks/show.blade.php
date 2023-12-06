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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswa as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nama_siswa }}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#tambah-pembelian-lks-{{ $data->id }}">
                                        Beli Lks
                                    </button>
                                    <a href="{{ route('pembelian-lks.show', $data->id) }}"
                                        class="btn btn-info btn-sm"><i class="nav-icon fas fa-search-plus"></i> &nbsp;
                                        Riwayat Pembelian
                                    </a>
                                </td>
                            </tr>

                            <div class="modal" id="tambah-pembelian-lks-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Pembelian LKS {{ $data->nama_siswa }}</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('pembelian-lks.store') }}" method="post" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="hidden" name="siswa_id" value="{{ $data->id }}">
                                                        <div class="form-group">
                                                            <label for="nama">Nama LKS</label>
                                                            <input type="text" id="nama" name="nama"
                                                                class="form-control @error('nama') is-invalid @enderror" placeholder="nama">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="harga">Harga</label>
                                                            <input type="text" id="harga" name="harga"
                                                                class="form-control @error('harga') is-invalid @enderror" placeholder="harga">
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
