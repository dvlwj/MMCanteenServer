@extends('layouts.app')

@section('title')
{{ request()->path() }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Absen</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <select class="selectpicker" id="sortKelasID" data-size="5">
                      <option value="">Kelas</option>
                      @foreach($kelas as $k)
                      <option value="{{ $k->id }}">{{ $k->name }}</option>
                      @endforeach
                    </select>
                    <select class="selectpicker" id="sortThAjaranID" data-size="5">
                      <option value="">Tahun Ajaran</option>
                      @foreach($thAjaran as $t)
                      <option value="{{ $t->id }}">{{ $t->tahun }}</option>
                      @endforeach
                    </select>
                    <hr>
                    <select class="selectpicker" id="sortBulan" data-size="5" onchange="getBulan()">
                      <option value="">Bulan</option>
                      @foreach($bulan as $a => $b)
                      <option value="{{ $a+1 }}">{{ $b }}</option>
                      @endforeach
                    </select>
                    <select class="selectpicker" id="sortTahun" data-size="5">
                      <option value="">Tahun</option>
                      <option value=""></option>
                    </select>
                    <select class="selectpicker" id="sortTime" data-size="5">
                      <option value="">Waktu</option>
                      <option value="pagi">Pagi</option>
                      <option value="siang">Siang</option>
                    </select>
                    <hr>

                    <table id="absen" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Tahun Ajaran</th>
                                <th>Time</th>
                                <th>Status</th>
                                @if(Auth::user()->role == 'admin')
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>10923872309</td>
                                <td>Ari Purwoto</td>
                                <td>1A</td>
                                <td>2018</td>
                                <td>2011/04/25</td>
                                <td>
                                  <!-- <span class="label label-success">pagi</span> -->
                                  <span class="label label-warning">siang</span>
                                </td>
                                @if(Auth::user()->role == 'admin')
                                    <td>
                                        <button class="btn btn-warning">Edit</button>
                                        <button class="btn btn-danger">Delete</button>
                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>10923872303</td>
                                <td>Gunawan Handoko </td>
                                <td>1B</td>
                                <td>2018</td>
                                <td>2011/04/26</td>
                                <td>
                                  <span class="label label-success">pagi</span>
                                  <!-- <span class="label label-warning">siang</span> -->
                                </td>
                                @if(Auth::user()->role == 'admin')
                                    <td>
                                        <button class="btn btn-warning">Edit</button>
                                        <button class="btn btn-danger">Delete</button>
                                    </td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#absen').DataTable();
    } );

    function getBulan(){
        console.log($('#sortBulan').val());
    }
</script>
@endsection