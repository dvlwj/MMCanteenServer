@extends('layouts.app')

@section('title')
{{ request()->path() }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
        	<div class="row" id="qrPrint">
	   			<div class="col-md-10 col-md-offset-1">
		   			<!-- TABLE SUCCESS -->
		   			@if($success != null)
		   			<table class="table table-bordered">
					  <thead class="thead-dark">
					    <tr>
					      <th scope="col">#</th>
					      <th scope="col">NIS</th>
					      <th scope="col">Nama</th>
					      <th scope="col">Info</th>
					    </tr>
					  </thead>
					  <tbody>
					  	@php $n=1 @endphp
		   				@foreach($success as $s)
					    <tr>
					      <th scope="row">{{$n++}}</th>
					      <td scope="row">{{$s['nis']}}</td>
					      <td scope="row">{{$s['name']}}</td>
					      <td scope="row"><span class="label label-success">{{$s['msg']}}</span></td>
					    </tr>
			   			@endforeach
					  </tbody>
					</table>
					@endif

					<!-- TABLE ERROR -->
					@if($error != null)
		   			<table class="table table-bordered">
					  <thead class="thead-dark">
					    <tr>
					      <th scope="col">#</th>
					      <th scope="col">NIS</th>
					      <th scope="col">Nama</th>
					      <th scope="col">Info</th>
					    </tr>
					  </thead>
					  <tbody>
					  	@php $n=1 @endphp
		   				@foreach($error as $er)
					    <tr>
					      <th scope="row">{{$n++}}</th>
					      <td scope="row">{{$er['nis']}}</td>
					      <td scope="row">{{$er['name']}}</td>
					      <td scope="row"><span class="label label-danger">{{$er['msg']}}</span></td>
					    </tr>
			   			@endforeach
					  </tbody>
					</table>
					@endif
	   			</div>
        	</div>
        	<br>
        	<div class="row">
		   		<p class="text-center">
		   			<a href="{{ route('siswa.index') }}" type="button" class="btn btn-danger">Back</a>
		   		</p>
        	</div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function printDiv(divName){
			var printContents = document.getElementById(divName).innerHTML;
			var originalContents = document.body.innerHTML;
			document.body.innerHTML = printContents;
			window.print();
			document.body.innerHTML = originalContents;
		}
</script>
@endsection