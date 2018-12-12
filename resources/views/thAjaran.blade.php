@extends('layouts.app')

@section('title')
{{ request()->path() }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Tahun Ajaran</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                      Tambah Tahun Ajaran +
                    </button>
                    <hr>
                    
                    <table id="th-ajaran" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Tahun Ajaran</th>
                                <th>ID</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>
                                    <button class="btn btn-warning">Edit</button>
                                    <button class="btn btn-danger">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Form Tambah Data Tahun Ajaran</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="th-ajaran" class="col-form-label">Tahun Ajaran</label>
                    <input type="text" class="form-control" id="th-ajaran" onkeypress="yearValidation(this.value,event)" oninput="checkNumberFieldLength(this);">
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save</button>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
    $('#th-ajaran').DataTable();
} );

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