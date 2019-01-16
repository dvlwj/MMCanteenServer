@extends('layouts.app')

@section('title')
{{ request()->path() }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <div class="row">
              <select class="selectpicker" id="bulan" data-size="5">
                <option value="">Pilih Bulan</option>
                @foreach($bulan as $k => $b)
                <option value="{{ $k+1 }}">{{ $b }}</option>
                @endforeach
              </select>
              <select class="selectpicker" id="tahun" data-size="5">
                <option value="">Pilih Tahun</option>
                @foreach($tahun as $t)
                <option value="{{ $t->tahun }}">{{ $t->tahun }}</option>
                @endforeach
              </select>
              <button class="btn btn-primary" onclick="checkReport()">Check</button>
          </div>
          <br>
          <div class="row" id="report" style="border: solid 2px black; border-radius: 5px;">
            <div class="col-sm-5">
              <br>
              <b>NIS : {{$siswa->nis}}</b>
              <br>
              <b>Nama : {{$siswa->name}}</b>
              <br>
              <b>Kelas : {{ $kelas->name }}</b>
            </div>
            <div class="col-sm-5">
              <br>
              <b>Tahun Ajaran : {{ $thAjaran->tahun }}</b>
              <br>
              <b>Periode : {{ $periode }}</b>
            </div>
            <div class="col-sm-2">
              <img src="{{ asset('img/logo.png') }}" alt="maitreyawira_logo" width="100px" height="100px">
            </div>
            <div class="col-sm-12">
              <hr>
              <table class="table">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Waktu</th>
                    <th scope="col">Biaya</th>
                  </tr>
                </thead>
                <tbody>
                  @php $n=1 @endphp
                  @foreach($report as $r)
                    <tr>
                      <td>{{$n++}}</td>
                      <td>{{ $r->time }}</td>
                      <td>{{ $r->status }}</td>
                      <td>Rp.{{ $harga[0]->harga }}</td>
                    </tr>
                  @endforeach
                  <tr align="right">
                    <td colspan="4"><b>Total : Rp.{{ $total }}</b></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <br>
          <div class="row">
          <p class="text-center">
            <a href="{{ route('siswa.index') }}" type="button" class="btn btn-danger">Back</a>
            <button class="btn btn-success" onclick="printDiv('report')">Print</button>
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

    function checkReport(){
      let bulan = $('#bulan').val();
      let tahun = $('#tahun').val();
      window.location = "http://"+window.location.hostname+"/report/{{$siswa->nis}}/"+bulan+"/"+tahun;
    }
</script>
@endsection