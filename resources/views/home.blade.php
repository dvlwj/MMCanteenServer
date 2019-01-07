@extends('layouts.app')

@section('title')
{{ request()->path() }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="text-center">
                        <img src="{{ asset('img/logo.png') }}" alt="maitreyawira_logo" width="350px" height="350px">
                        <br>
                        <h3>
                            Welcome {{ Auth::user()->username }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
