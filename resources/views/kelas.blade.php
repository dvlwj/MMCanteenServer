@extends('layouts.app')

@section('title')
{{ request()->path() }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Kelas</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addKelas">
                      Tambah Kelas +
                    </button>
                    <hr>

                    <table id="kelas" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">Kelompok</th>
                                <th class="text-center">Harga</th>
                                @if(Auth::user()->role == 'admin')
                                    <th class="text-center">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php $n=1 @endphp
                            @foreach($kelas as $data)
                            <tr>
                                <td class="text-center">{{$n++}}</td>
                                <td class="text-center">{{ $data->name }}</td>
                                <td class="text-center">{{ $data->kelompok->kel_kelas}}</td>
                                <td class="text-center">Rp {{ number_format($data->kelompok->harga, 2, ",", ".")}}</td>
                                @if(Auth::user()->role == 'admin')
                                    <td class="text-center">
                                        <button class="btn btn-warning" data-toggle="modal" data-target="#editKelas" onclick="getData('{{ $data->id }}')">
                                          Edit
                                        </button>
                                        <button class="btn btn-danger" onclick="deleteData('{{ $data->id }}')">Delete</button>
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

    <!-- MODAL ADD -->
    <div class="modal fade" id="addKelas" tabindex="-1" role="dialog" aria-labelledby="addKelasCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addKelasCenterTitle">Form Tambah Data Kelas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="name" class="col-form-label">Nama Kelas</label>
                    <input type="text" class="form-control" id="name">
                </div>
                <div class="form-group">
                    <label for="kelompok">Kelompok Kelas</label>
                    <select id="kelompok" class="form-control">
                        @foreach($harga as $hrg)
                            <option value="{{ $hrg->id }}">{{ $hrg->kel_kelas }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal" id="saveAdd">Save</button>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL EDIT -->
    <div class="modal fade" id="editKelas" tabindex="-1" role="dialog" aria-labelledby="editKelasCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editKelasCenterTitle">Form Edit Data Kelas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
                <div class="form-group">
                    <input type="hidden" class="form-control" id="editID">
                    <label for="editName" class="col-form-label">Nama Kelas</label>
                    <input type="text" class="form-control" id="editName">
                </div>
                <div class="form-group">
                    <label for="editKelompok">Kelompok Kelas</label>
                    <select id="editKelompok" class="form-control">
                        @foreach($harga as $hrg)
                            <option value="{{ $hrg->id }}">{{ $hrg->kel_kelas }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal" id="saveEdit">Save</button>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#kelas').DataTable();
    });

    $('#addKelas').bind('keydown', function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    });

    $('#editKelas').bind('keydown', function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    });

    // GET DATA KELAS
    function getData(id) {
        $.get('{{ route("kelas.index") }}/'+id, function(data) {
            $('#editName').val(data.name);
            $('#editKelompok').val(data.harga_id);
            $('#editID').val(data.id); 
        });
    }

    // ADD DATA KELAS
    $('#saveAdd').click(function(e) {
        e.preventDefault();
        
        if($('#name').val() == '') {
            alert("Nama kelas tidak boleh kosong!");
        } else {
            $.ajax({  
                url: '{{ route("kelas.index") }}',  
                type: 'POST',  
                dataType: 'json',  
                data: {
                    name: $('#name').val(),
                    harga_id: $('#kelompok').val()
                },  
                success: function (data) {
                    if(data.status == 0) {
                        alert(data.msg);
                    } else {
                        alert('Data berhasil ditambah.');
                        refreshForm();
                        $("#kelas").load(window.location + " #kelas");
                    }
                }
            });
        }
    });

    // EDIT DATA KELAS
    $('#saveEdit').click(function(e) {
        e.preventDefault();

        $.ajax({  
            url: '{{ route("kelas.index") }}/'+$('#editID').val(),  
            type: 'PATCH',  
            dataType: 'json',  
            data: {
                name: $('#editName').val(),
                harga_id: $('#editKelompok').val()
            },  
            success: function (data) {
                if(data.status == 0){
                    alert(data.msg);
                }else{
                    alert('Data berhasil diedit.');
                    $("#kelas").load(window.location + " #kelas");
                }
            }
        });
    });

    // DELETE DATA KELAS
    function deleteData(id) {
        let conf = confirm("Jika data ini dihapus, maka data Siswa yang terhubung dengan data ini akan terhapus. Apakah Anda yakin data ini akan dihapus ?");
        if(conf){
            $.ajax({  
                url: '{{ route("kelas.index") }}/'+id,  
                type: 'DELETE',  
                dataType: 'json', 
                success: function (data) {
                    if(data.status == 0){
                        alert(data.msg);
                    }else{
                        alert('Data berhasil dihapus.');
                        $("#kelas").load(window.location + " #kelas");
                    }
                }
            });
        }
    }

    function refreshForm() {
        $('#name').val('');
        $('#kelompok').val('');
    }
</script>
@endsection