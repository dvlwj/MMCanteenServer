@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Kelas</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <button class="btn btn-primary">Add Kelas +</button>
                    <br>
                    <hr>
                    List of Kelas <br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
