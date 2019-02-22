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
                                <th class="text-center">No</th>
                                <th class="text-center">Tahun Ajaran</th>
                                <th class="text-center">ID Tahun Ajaran</th>
                                @if(Auth::user()->role == 'admin')
                                    <th class="text-center">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php $n=1 @endphp
                            @foreach($thAjaran as $data)
                            <tr>
                                <td class="text-center">{{$n++}}</td>
                                <td class="text-center">{{ $data->tahun }}</td>
                                <td class="text-center">{{ $data->id }}</td>
                                @if(Auth::user()->role == 'admin')
                                    <td class="text-center">
                                        <button class="btn btn-warning" data-toggle="modal" data-target="#editTahunAjaran" onclick="getData('{{ $data->id }}')">
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
                    <input type="text" class="form-control" id="tahun" onkeypress="yearValidation(this.value,event)" oninput="checkNumberFieldLength(this);" placeholder="cth: 2015/2016">
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
    });

    $('#addTahunAjaran').bind('keydown', function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    });

    $('#editTahunAjaran').bind('keydown', function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    });

// GET DATA TAHUN AJARAN
    function getData(id) {
        $.get('{{ route("th-ajaran.index") }}/'+id, function(data) {
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
                url: '{{ route("th-ajaran.index") }}',  
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
            url: '{{ route("th-ajaran.index") }}/'+$('#editID').val(),  
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
        let conf = confirm("Jika data ini dihapus, maka data Siswa yang terhubung dengan data ini akan terhapus. Apakah Anda yakin data ini akan dihapus ?");
        if(conf){
            $.ajax({  
                url: '{{ route("th-ajaran.index") }}/'+id,  
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

  // var text = /^[0-9]{1,9}$/;
  var text = /\d{4}\/\d{4}/;
  if(year.length==9 && ev.keyCode!=8 && ev.keyCode!=46) {
    if (year != 0) {
        if ((year != "") && (!text.test(year))) {

            alert("Silahkan masukan dengan format nomor");
            return false;
        }

        if (year.length != 9) {
            alert("Tahun tidak sesuai. Silahkan diperbaiki");
            return false;
        }
        var current_year=new Date().getFullYear();
        if((year < 1990) || (year > current_year))
            {
            alert("Tahun yang tersedia 1990 sampai saat ini");
            return false;
            }
        return true;
    } }
}

function checkNumberFieldLength(elem){
    if (elem.value.length > 9) {
        elem.value = elem.value.slice(0,9); 
    }
}
</script>
@endsection