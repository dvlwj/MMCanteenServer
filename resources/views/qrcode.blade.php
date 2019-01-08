@extends('layouts.app')

@section('title')
{{ request()->path() }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
        	<div class="row" id="qrPrint">
	   			<div class="col-sm-12" style="border: 3px solid black">
	   				<div class="col-sm-6">
				   		<p class="text-center">
				   			{!! QrCode::size(300)->generate($nis); !!}
				   		</p>
			   		</div>
	   				<div class="col-sm-6">
				   		<p class="text-center" style="font-size: 16px">
				   			<br><br><br><br><br>
				   			<b>{{$nis}}</b>
				   			<br>
				   			<b>{{strtoupper($name)}}</b>
				   			<br><br>
					   		property ini milik kantin <b>maitreyawira</b>, jika menemukan harap dikembalikan.
				   		</p>
				   	</div>
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