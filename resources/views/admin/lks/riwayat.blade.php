@extends('template_backend.home')
@section('heading', 'Riwayat Pembelian LKS' . $siswa->nama_siswa)
@section('page')
    <li class="breadcrumb-item active">Riwayat Pembelian LKS</li>
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
                            <th>Nama LKS</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lks as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->created_at->format('d-m-Y') }}</td>
                                <td>{{ $data->nama }}</td>
                                <td>
                                    {{ 'Rp. ' . number_format($data->harga, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection