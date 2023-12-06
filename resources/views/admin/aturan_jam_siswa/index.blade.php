@extends('template_backend.home')
@section('heading', 'Data Aturan Jam Siswa')
@section('page')
  <li class="breadcrumb-item active">Data Aturan Jam Siswa</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
          <h3 class="card-title">
              <button type="button" class="btn btn-primary btn-sm" onclick="getCreateJamAturanSiswa()" data-toggle="modal" data-target="#form-aturan-jam-siswa">
                  <i class="nav-icon fas fa-folder-plus"></i> &nbsp; Tambah Data Aturan Jam Siswa
              </button>
          </h3>
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
                    <th>Status</th>
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
                      <span class="badge badge-pill{{ $data->status == 0 ? 'badge-secondary' : 'badge-success' }}"></span>
                      {{ $data->status == 0 ? 'Tidak Aktif' : 'Aktif' }}
                    </td>
                    <td>
                        <form action="{{ route('kelas.destroy', $data->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-success btn-sm" onclick="getEditAturanJamSiswa({{$data->id}})" data-toggle="modal" data-target="#form-aturan-jam-siswa">
                              <i class="nav-icon fas fa-edit"></i> &nbsp; Edit
                            </button>
                            <button class="btn btn-danger btn-sm"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
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

<!-- Extra large modal -->
<div class="modal fade bd-example-modal-md" id="form-aturan-jam-siswa" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title" id="judul"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('aturan-jam-siswa.store') }}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" id="id" name="id">
              <div class="form-group" id="form_nama_aturan">
                <label for="nama_aturan">Nama Kelas</label>
                <input type='text' id="nama_aturan" onkeyup="this.value = this.value.toUpperCase()" name='nama_aturan' class="form-control @error('nama_aturan') is-invalid @enderror" placeholder="{{ __('Nama Aturan') }}">
              </div>
              <div class="form-group" id="form_jam_masuk">
                <label for="jam_masuk">Jam Masuk</label>
                <input type='time' id="jam_masuk" name='jam_masuk' class="form-control @error('jam_masuk') is-invalid @enderror" placeholder="{{ __('Jam Masuk') }}">
              </div>
              <div class="form-group" id="form_jam_pulang">
                <label for="jam_pulang">Jam Pulang</label>
                <input type='time' id="jam_pulang" name='jam_pulang' class="form-control @error('jam_pulang') is-invalid @enderror" placeholder="{{ __('Jam Pulang') }}">
              </div>
              <div class="form-group" id="form_status">
                <input type="radio" name="status" value="1" id="optionStatusAktif">
                <label for="optionStatusAktif">Aktif</label>
                <input type="radio" name="status" value="0" id="optionStatusNonaktif">
                <label for="optionStatusNonaktif">Tidak Aktif</label>
              </div>
            </div>
          </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</button>
            <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
@section('script')
  <script>
    function getCreateJamAturanSiswa(){
      $("#judul").text('Tambah Data Jam Aturan Siswa');
      $('#id').val('');
      $('#form_nama_aturan').html(`
        
      `);
      $('#nama_aturan').val('');
      $('#jam_masuk').val('');
      $('#jam_pulang').val('');
      $('#status').val(0);
    }

    function getEditAturanJamSiswa(id){
      var parent = id;
      $.ajax({
        type:"GET",
        data:"id="+parent,
        dataType:"JSON",
        url:"{{ url('/aturan-jam-siswa/edit/json') }}",
        success:function(result){
          if(result){
            $.each(result,function(index, val){
              $("#judul").text('Edit Data Aturan Jam Siswa ' + val.nama_aturan);
              $('#id').val(val.id);
              $('#nama_aturan').val(val.nama_aturan);
              $('#jam_masuk').val(val.jam_masuk);
              $('#jam_pulang').val(val.jam_pulang);
              $('#optionStatus' + (val.status == 0 ? 'Nonaktif' : 'Aktif')).prop('checked', true);
            });
          }
        },
        error:function(e){
          toastr.error("Errors 404!");
        },
        complete:function(){
        }
      });
    }

    $("#MasterData").addClass("active");
    $("#liMasterData").addClass("menu-open");
    $("#DataKelas").addClass("active");
  </script>
@endsection