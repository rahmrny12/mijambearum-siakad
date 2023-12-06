@extends('template_backend.home')
@section('heading', 'Riwayat Tabungan ' . $siswa->nama_siswa)
@section('page')
    <li class="breadcrumb-item active">Riwayat Tabungan</li>
@endsection
@section('content')
    <div class="ml-2 mb-3">
        <button onclick="window.history.back()" class="btn btn-default"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</button> &nbsp;
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Nominal</th>
                            <th>Jenis Tabungan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayat_tabungan as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->created_at->format('d-m-Y') }}</td>
                                <td>
                                    {{ $data->jenis_tabungan == 'menabung' ? '' : '-' }} {{ 'Rp. ' . number_format($data->nominal, 0, ',', '.') }}
                                </td>
                                <td>
                                    {{ $data->jenis_tabungan == 'menabung' ? 'Menabung' : 'Penarikan' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection