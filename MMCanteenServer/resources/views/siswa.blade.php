@extends('layouts.app')

@section('title')
{{ request()->path() }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Siswa</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                      Tambah Siswa +
                    </button>
                    <hr>
                    List of Siswa <br>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Form Tambah Data Siswa</h5>
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
            <button type="button" class="btn btn-primary">Save</button>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
