@extends('layouts.app')

@section('title')
{{ request()->path() }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Siswa</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(Auth::user()->role == 'admin')
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSiswa">
                          Tambah Siswa +
                        </button>
                        <hr>
                    @endif
                    
                    <table id="siswa" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Tahun Ajaran</th>
                                @if(Auth::user()->role == 'admin')
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswa as $data)
                            <tr>
                                <td>{{ $data->nis }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->kelas_id }}</td>
                                <td>{{ $data->th_ajaran_id }}</td>
                                @if(Auth::user()->role == 'admin')
                                    <td>
                                        <button class="btn btn-warning">Edit</button>
                                        <button class="btn btn-danger">Delete</button>
                                    </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addSiswa" tabindex="-1" role="dialog" aria-labelledby="addSiswaCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addSiswaCenterTitle">Form Tambah Data Siswa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="nis" class="col-form-label">NIS</label>
                    <input type="text" class="form-control" id="nis" placeholder="Nomor Induk Siswa">
                </div>
                <div class="form-group">
                    <label for="namaSiswa" class="col-form-label">Nama Siswa</label>
                    <input type="text" class="form-control" id="namaSiswa" placeholder="Nama Lengkap Siswa">
                </div>
                <div class="form-group">
                    <label for="kelasID">Kelas</label>
                    <select id="kelasID" class="form-control">
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="thAjaranID">Tahun Ajaran</label>
                    <select id="thAjaranID" class="form-control">
                        @foreach($thAjaran as $th)
                            <option value="{{ $th->id }}">{{ $th->tahun }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#siswa').DataTable();
    } );

    //REFRESH FORM
    function refreshForm() {
        $('#nis').val('');
        $('#namaSiswa').val('');
        $('#kelasID').val('');
        $('#thAjaranID').val('');
    }
</script>
@endsection