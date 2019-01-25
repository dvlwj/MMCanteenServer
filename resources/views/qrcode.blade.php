@extends('layouts.app')

@section('title')
{{ request()->path() }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
        	<div class="row" id="qrPrint">
	   			<div class="col-sm-12">
	   				@if($ket == 'more')
		   				@foreach($siswa as $s)
			   			<!-- CARD -->
			   			<div class="col-sm-3 col-xs-3" style="border: 2px solid black; margin: 5px 0;">
				   			<div class="card text-center">
					   					{!! QrCode::size(150)->generate($s->nis); !!}
							  	<div class="card-body">
							    	<p class="card-text text-center">
							    		<b>Kelas {{$kelas->name}}</b> <br> <b>{{$s->name}}</b>
							    	</p>
							  	</div>
							</div>
						</div>
						<!-- /CARD -->
						@endforeach
					@elseif($ket == 'one')
					<!-- CARD -->
			   			<div class="col-sm-3 col-xs-3" style="border: 2px solid black; margin: 5px 0;">
				   			<div class="card text-center">
					   					{!! QrCode::size(150)->generate($siswa->nis); !!}
							  	<div class="card-body">
							    	<p class="card-text text-center">
							    		<b>Kelas {{$kelas->name}}</b> <br> <b>{{$siswa->name}}</b>
							    	</p>
							  	</div>
							</div>
						</div>
						<!-- /CARD -->
					@endif
	   			</div>
        	</div>
        	<br>
        	<div class="row">
		   		<p class="text-center">
		   			<a href="{{ route('siswa.index') }}" type="button" class="btn btn-danger">Back</a>
		   			<button class="btn btn-success" onclick="printDiv('qrPrint')">Print</button>
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