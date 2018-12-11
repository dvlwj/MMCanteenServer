@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Petugas</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <button class="btn btn-primary">Add Petugas +</button>
                    <br>
                    <hr>
                    List of Petugas <br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
