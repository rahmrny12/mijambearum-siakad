@extends('template_backend.home')
@section('heading', 'Trash Aturan Jam Siswa')
@section('page')
  <li class="breadcrumb-item active">Trash Aturan Jam Siswa</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Trash Data Aturan Jam Siswa</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Aturan</th>
                    <th>Jam Masuk</th>
                    <th>Jam Pulang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($aturan_jam_siswa as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->nama_aturan }}</td>
                    <td>{{ $data->jam_masuk }}</td>
                    <td>{{ $data->jam_pulang }}</td>
                    <td>
                        <form action="{{ route('aturan-jam-siswa.kill', $data->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <a href="{{ route('aturan-jam-siswa.restore', Crypt::encrypt($data->id)) }}" class="btn btn-success btn-sm mt-2"><i class="nav-icon fas fa-undo"></i> &nbsp; Restore</a>
                            <button class="btn btn-danger btn-sm mt-2"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
          </table>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $("#ViewTrash").addClass("active");
        $("#liViewTrash").addClass("menu-open");
        $("#TrashAturan Jam Siswa").addClass("active");
    </script>
@endsection