@extends('layouts.app')

@section('title')
{{ request()->path() }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Tahun Ajaran</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTahunAjaran">
                      Tambah Tahun Ajaran +
                    </button>
                    <hr>
                    
                    <table id="thAjaran" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tahun Ajaran</th>
                                @if(Auth::user()->role == 'admin')
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($thAjaran as $data)
                            <tr>
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->tahun }}</td>
                                @if(Auth::user()->role == 'admin')
                                    <td>
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editTahunAjaran" onclick="getData('{{ $data->id }}')">
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

    <!-- ADD MODAL -->
    <div class="modal fade" id="addTahunAjaran" tabindex="-1" role="dialog" aria-labelledby="addTahunAjaranCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addTahunAjaranCenterTitle">Form Tambah Data Tahun Ajaran</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="tahun" class="col-form-label">Tahun Ajaran</label>
                    <input type="text" class="form-control" id="tahun" onkeypress="yearValidation(this.value,event)" oninput="checkNumberFieldLength(this);">
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
    <div class="modal fade" id="editTahunAjaran" tabindex="-1" role="dialog" aria-labelledby="editTahunAjaranCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editTahunAjaranCenterTitle">Form Edit Data Tahun Ajaran</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
                <div class="form-group">
                    <input type="hidden" class="form-control" id="editID">
                    <label for="editTahun" class="col-form-label">Tahun Ajaran</label>
                    <input type="text" class="form-control" id="editTahun" onkeypress="yearValidation(this.value,event)" oninput="checkNumberFieldLength(this);">
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
    $('#thAjaran').DataTable();
} );

// GET DATA TAHUN AJARAN
    function getData(id) {
        $.get('http://localhost:8000/th-ajaran/'+id, function(data) {
            $('#editTahun').val(data.tahun);
            $('#editID').val(data.id); 
        });
    }

// ADD DATA TAHUN AJARAN
    $('#saveAdd').click(function(e) {
        e.preventDefault();
        if($('#tahun').val() == '') {
            alert("Tahun Ajaran tidak boleh kosong!");
        } else {
            $.ajax({  
                url: 'http://localhost:8000/th-ajaran',  
                type: 'POST',  
                dataType: 'json',  
                data: {
                    tahun: $('#tahun').val()
                },  
                success: function (data) {
                    if(data.status == 0) {
                        alert(data.msg);
                    } else {
                        alert('Data berhasil ditambah.');
                        refreshForm();
                        $("#thAjaran").load(window.location + " #thAjaran");
                    }
                }
            });
        }
    });

// EDIT DATA TAHUN AJARAN
    $('#saveEdit').click(function(e) {
        e.preventDefault();

        $.ajax({  
            url: 'http://localhost:8000/th-ajaran/'+$('#editID').val(),  
            type: 'PATCH',  
            dataType: 'json',  
            data: {
                tahun: $('#editTahun').val()
            },  
            success: function (data) {
                if(data.status == 0){
                    alert(data.msg);
                }else{
                    alert('Data berhasil diedit.');
                    $("#thAjaran").load(window.location + " #thAjaran");
                }
            }
        });
    });

// DELETE DATA KELAS
    function deleteData(id) {
        let conf = confirm("Apakah anda yakin data ini akan dihapus ?");
        if(conf){
            $.ajax({  
                url: 'http://localhost:8000/th-ajaran/'+id,  
                type: 'DELETE',  
                dataType: 'json', 
                success: function (data) {
                    if(data.status == 0){
                        alert(data.msg);
                    }else{
                        console.log(window.location);
                        alert('Data berhasil dihapus.');
                        $("#thAjaran").load(window.location + " #thAjaran");
                    }
                }
            });
        }
    }

    function refreshForm() {
        $('#tahun').val('');
    }

// VALIDATE YEAR
function yearValidation(year,ev) {

  var text = /^[0-9]{1,4}$/;
  if(year.length==4 && ev.keyCode!=8 && ev.keyCode!=46) {
    if (year != 0) {
        if ((year != "") && (!text.test(year))) {

            alert("Please Enter Numeric Values Only");
            return false;
        }

        if (year.length != 4) {
            alert("Year is not proper. Please check");
            return false;
        }
        var current_year=new Date().getFullYear();
        if((year < 1990) || (year > current_year))
            {
            alert("Year should be in range 1990 to current year");
            return false;
            }
        return true;
    } }
}

function checkNumberFieldLength(elem){
    if (elem.value.length > 4) {
        elem.value = elem.value.slice(0,4); 
    }
}
</script>
@endsection