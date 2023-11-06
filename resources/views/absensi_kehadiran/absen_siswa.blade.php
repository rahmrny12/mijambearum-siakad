@extends('layouts.absensi-app')
@section('page', 'MI JAMBEARUM')
@section('content')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <div class="col-md-4">
            <input type="text" class="form-control" id="id_card" placeholder="Masukkan ID Card">
        </div>
        <div class="col-md-6 card my-4 d-none">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span>Tanggal : 00 - 00</span>
                    <span class="badge badge-success badge-pill p-3">00:00:00</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <div class="col-md-6">
                        <div class="my-4">
                            <span class="d-block">Nama Siswa :</span>
                            <span>-</span>
                        </div>
                        <div class="my-4">
                            <span class="d-block">Kelas :</span>
                            <span>-</span>
                        </div>
                        <div class="my-4">
                            <span class="d-block">Jenis Kelamin :</span>
                            <span>-</span>
                        </div>
                        <div class="my-4">
                            <span class="d-block">NISN :</span>
                            <span>-</span>
                        </div>
                    </div>
                    <img src="" alt="Foto Siswa">
                </div>
            </div>
        </div>
    </div>
@endsection
