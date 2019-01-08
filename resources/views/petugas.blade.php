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
                                <th class="text-center">No</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Role</th>
                                @if(Auth::user()->role == 'admin')
                                    <th class="text-center">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php $n=1 @endphp
                            @foreach($petugas as $data)
                            <tr>
                                @if($data->username != 'system')
                                    <td class="text-center">{{$n++}}</td>
                                    <td>{{ $data->username }}</td>
                                    <td class="text-center">
                                        @if($data->role == 'admin')
                                        <span class="label label-danger">{{ $data->role }}</span>
                                        @else
                                        <span class="label label-primary">{{ $data->role }}</span>
                                        @endif
                                    </td>
                                    @if(Auth::user()->role == 'admin')
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editPetugas" onclick="getData('{{ $data->id }}')">Change Username</button>
                                            <button class="btn btn-info" onclick="changeRole('{{ $data->id }}','{{ $data->role }}')">Change Role</button>
                                            <button class="btn btn-warning" onclick="resetPassword('{{ $data->id }}')">
                                              Reset Password
                                            </button>
                                            <button class="btn btn-danger" onclick="deleteData('{{ $data->id }}')">Delete</button>
                                        </td>
                                    @endif
                                @endif
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

    <!-- ADD MODAL -->
    <div class="modal fade" id="editPetugas" tabindex="-1" role="dialog" aria-labelledby="editPetugasCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="EditPetugasCenterTitle">Form Edit Username Petugas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="form_add">
                <div class="form-group">
                    <input type="hidden" class="form-control" id="editID">
                    <label for="editUsername" class="col-form-label">Username</label>
                    <input type="text" class="form-control" id="editUsername" placeholder="Username">
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

        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    });

    // GET DATA PETUGAS
    function getData(id) {
        $.get('{{ route("petugas.index") }}/'+id, function(data) {
            $('#editUsername').val(data.username);
            $('#editID').val(data.id); 
        });
    }

    $('#saveAdd').click(function(e) {
        e.preventDefault();
        if($('#username').val() == '') {
            alert("Username tidak boleh kosong!");
        } else {
            if($('#username').val().length < 5){
                alert('Username minimal 5 karakter!');
            }else if($('#username').val().includes(' ') == true){
                alert('Username tidak boleh menggunakan sepasi!');
            }else{
                $.ajax({  
                    url: '{{ route("petugas.index") }}',  
                    type: 'POST',  
                    dataType: 'json',  
                    data: {
                        username: $('#username').val(),
                        role: $('#role').val()
                    },  
                    success: function (data) {
                        if(data.status == 0) {
                            alert(data.msg);
                        } else {
                            alert('Data berhasil ditambah.');
                            refreshForm();
                            $("#petugas").load(window.location + " #petugas");
                        }
                    }
                });
            }
        }
    });

    // EDIT DATA PETUGAS
    $('#saveEdit').click(function(e) {
        e.preventDefault();

        $.ajax({  
            url: '{{ route("petugas.index") }}/'+$('#editID').val(),  
            type: 'PATCH',  
            dataType: 'json',  
            data: {
                username: $('#editUsername').val()
            },  
            success: function (data) {
                if(data.status == 0){
                    alert(data.msg);
                }else{
                    alert('Data berhasil diedit.');
                    $("#petugas").load(window.location + " #petugas");
                }
            }
        });
    });

    function resetPassword(id){
        $.ajax({  
            url: '{{ route("petugas.index") }}/'+id,  
            type: 'PATCH',  
            dataType: 'json',  
            data: {
                reset: true
            },  
            success: function (data) {
                if(data.status == 0){
                    alert(data.msg);
                }else{
                    alert('Password berhasil direset.');
                    $("#petugas").load(window.location + " #petugas");
                }
            }
        });
    }

    function changeRole(id, roleName){
        $.ajax({  
            url: '{{ route("petugas.index") }}/'+id,  
            type: 'PATCH',  
            dataType: 'json',  
            data: {
                role: roleName
            },  
            success: function (data) {
                if(data.status == 0){
                    alert(data.msg);
                }else{
                    alert('Role berhasil diganti.');
                    window.location.reload();
                    let userRole = '{{Auth::user()->role}}';
                    if( userRole == 'petugas'){
                        window.location.href='{{ route("home") }}';
                    }else{
                        $("#petugas").load(window.location + " #petugas");
                    }
                }
            }
        });
    }

    function deleteData(id) {
        let conf = confirm("Jika data Petugas dihapus, maka data di Absen yang terhubung akan terhapus. Apakah Anda yakin data ini akan dihapus ?");
        if(conf){
            $.ajax({  
                url: '{{ route("petugas.index") }}/'+id,  
                type: 'DELETE',  
                dataType: 'json', 
                success: function (data) {
                    if(data.status == 0){
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
        $('#role').val('petugas');
    }
</script>
@endsection