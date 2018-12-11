@extends('layouts.app')

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

                    <button class="btn btn-primary">Add Siswa +</button>
                    <br>
                    <hr>
                    List of Siswa <br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
