@extends('layouts.app')

@section('title')
{{ request()->path() }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Petugas</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPetugas">
                      Tambah Petugas +
                    </button>
                    <hr>
                    
                    <table id="petugas" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($petugas as $data)
                            <tr>
                                <td>{{ $data->username }}</td>
                                <td>******</td>
                                <td><span class="badge badge-pill badge-primary">{{ $data->role }}</span></td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editPetugas" onclick="getData('{{ $data->id }}')">
                                      Edit
                                    </button>
                                    <button class="btn btn-danger" onclick="deleteData('{{ $data->id }}')">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- ADD MODAL -->
    <div class="modal fade" id="addPetugas" tabindex="-1" role="dialog" aria-labelledby="addPetugasCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addPetugasCenterTitle">Form Tambah Data Petugas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="form_add">
                <div class="form-group">
                    <label for="username" class="col-form-label">Username</label>
                    <input type="text" class="form-control" id="username" placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="password" class="col-form-label">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" class="form-control">
                        <option value="petugas">Petugas</option>
                        <option value="admin">Admin</option>
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

    <!-- EDIT MODAL -->
    <div class="modal fade" id="editPetugas" tabindex="-1" role="dialog" aria-labelledby="editPetugasCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editPetugasCenterTitle">Form Edit Data Petugas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="form_edit">
                <input type="hidden" class="form-control" id="editID">
                <div class="form-group">
                    <label for="editUsername" class="col-form-label">Username</label>
                    <input type="text" class="form-control" id="editUsername" placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="editPassword" class="col-form-label">Password</label>
                    <input type="password" class="form-control" id="editPassword" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="editRole">Role</label>
                    <select id="editRole" class="form-control">
                        <option value="petugas">Petugas</option>
                        <option value="admin">Admin</option>
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
        $('#petugas').DataTable();
    });

    function getData(id) {
        $.get('http://localhost:8000/petugas/'+id, function(data) {
            $('#editUsername').val(data.username);
            $('#editRole').val(data.role);
            $('#editID').val(data.id); 
        });
    }

    $('#saveAdd').click(function(e) {
        e.preventDefault();
        if($('#username').val() == '' || $('#password').val() == '') {
            alert("Username atau Password tidak boleh kosong!");
        } else {
            $.ajax({  
                url: 'http://localhost:8000/petugas',  
                type: 'POST',  
                dataType: 'json',  
                data: {
                    username: $('#username').val(),
                    password: $('#password').val(),
                    role: $('#role').val()
                },  
                success: function (data) {
                    if(data.status == 'fail') {
                        alert(data.msg);
                    } else {
                        alert('Data berhasil ditambah.');
                        refreshForm();
                        $("#petugas").load(window.location + " #petugas");
                    }
                }
            });
        }
    });

    $('#saveEdit').click(function(e) {
        e.preventDefault();

        $.ajax({  
            url: 'http://localhost:8000/petugas/'+$('#editID').val(),  
            type: 'PATCH',  
            dataType: 'json',  
            data: {
                username: $('#editUsername').val(),
                password: $('#editPassword').val(),
                role: $('#editRole').val()
            },  
            success: function (data) {
                if(data.status == 'fail'){
                    alert(data.msg);
                }else{
                    alert('Data berhasil diedit.');
                    $("#petugas").load(window.location + " #petugas");
                }
            }
        });
    });

    function deleteData(id) {
        let conf = confirm("Apakah anda yakin data ini akan dihapus ?");
        if(conf){
            $.ajax({  
                url: 'http://localhost:8000/petugas/'+id,  
                type: 'DELETE',  
                dataType: 'json', 
                success: function (data) {
                    if(data.status == 'fail'){
                        alert(data.msg);
                    }else{
                        alert('Data berhasil dihapus.');
                        $("#petugas").load(window.location + " #petugas");
                    }
                }
            });
        }
    }

    function refreshForm() {
        $('#username').val('');
        $('#password').val('');
        $('#role').val('petugas');
    }
</script>
@endsection