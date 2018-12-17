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
                                <th>Kelas</th>
                                <th>ID</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kelas as $data)
                            <tr>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->id }}</td>
                                @if(Auth::user()->role == 'admin')
                                    <td>
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editKelas" onclick="getData('{{ $data->id }}')">
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
    } );

    // GET DATA KELAS
    function getData(id) {
        $.get('http://localhost:8000/kelas/'+id, function(data) {
            $('#editName').val(data.name);
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
                url: 'http://localhost:8000/kelas',  
                type: 'POST',  
                dataType: 'json',  
                data: {
                    name: $('#name').val()
                },  
                success: function (data) {
                    if(data.status == 'fail') {
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
            url: 'http://localhost:8000/kelas/'+$('#editID').val(),  
            type: 'PATCH',  
            dataType: 'json',  
            data: {
                name: $('#editName').val()
            },  
            success: function (data) {
                if(data.status == 'fail'){
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
        let conf = confirm("Apakah anda yakin data ini akan dihapus ?");
        if(conf){
            $.ajax({  
                url: 'http://localhost:8000/kelas/'+id,  
                type: 'DELETE',  
                dataType: 'json', 
                success: function (data) {
                    if(data.status == 'fail'){
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
    }
</script>
@endsection