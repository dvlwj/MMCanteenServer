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
                    <select class="selectpicker" id="sortBulan" data-size="5">
                      <option value="">Bulan</option>
                      @foreach($bulan as $a => $b)
                      <option value="{{ $a+1 }}">{{ $b }}</option>
                      @endforeach
                    </select>
                    <select class="selectpicker" id="sortTahun" data-size="5">
                      <option value="">Tahun</option>
                      @foreach($absen as $data)
                      <option value="{{ $data->thAjaran->id }}">{{ $data->thAjaran->tahun }}</option>
                      @endforeach
                    </select>
                    <select class="selectpicker" id="sortTime" data-size="5">
                      <option value="">Waktu</option>
                      <option value="pagi">Pagi</option>
                      <option value="siang">Siang</option>
                    </select>
                    <button class="btn btn-primary" id="sort">Sortir</button>
                    <hr>

                    <table id="absen" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">NIS</th>
                                <th class="text-center">Nama Siswa</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">Tahun Ajaran</th>
                                <th class="text-center">Waktu</th>
                                <th class="text-center">Status</th>
                                <!-- @if(Auth::user()->role == 'admin')
                                    <th class="text-center">Action</th>
                                @endif -->
                            </tr>
                        </thead>
                        <tbody>
                          @php $n=1 @endphp
                          @foreach($absen as $data)
                            <tr>
                                <td class="text-center">{{$n++}}</td>
                                <td class="text-center">{{ $data->siswa->nis }}</td>
                                <td>{{ $data->siswa->name }}</td>
                                <td class="text-center">{{ $data->kelas->name }}</td>
                                <td class="text-center">{{ $data->thAjaran->tahun }}</td>
                                <td class="text-center">{{ $data->time }}</td>
                                <td class="text-center">
                                  @if($data->status == 'pagi')
                                    <span class="label label-success">pagi</span>
                                  @else
                                    <span class="label label-warning">siang</span>
                                  @endif
                                </td>
                                <!-- @if(Auth::user()->role == 'admin')
                                    <td>
                                        <button class="btn btn-warning">Edit</button>
                                        <button class="btn btn-danger">Delete</button>
                                    </td>
                                @endif -->
                            </tr>
                          @endforeach
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