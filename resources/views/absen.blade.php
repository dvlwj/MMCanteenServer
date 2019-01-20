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

                    @if(Auth::user()->role == 'admin')
                    <select class="selectpicker" id="waktu" data-size="5">
                        <option value="">Pilih Waktu</option>
                        <option value="pagi">Pagi</option>
                        <option value="siang">Siang</option>
                    </select>
                    <button class="btn btn-success" onclick="generateAbsen()">Generate Absen</button>
                    <hr>
                    @endif

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
                                <th class="text-center">Keterangan</th>
                                @if(Auth::user()->role == 'admin')
                                  <th class="text-center">Action</th>
                                @endif
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
                                <td class="text-center">
                                  @if($data->keterangan == 'makan')
                                    <span class="label label-success">Makan</span>
                                  @else
                                    <span class="label label-danger">Tidak Makan</span>
                                  @endif
                                </td>
                                @if(Auth::user()->role == 'admin')
                                  <td>
                                      <button class="btn btn-danger" onclick="deleteData('{{ $data->id }}')">Delete</button>
                                  </td>
                                @endif
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

    function generateAbsen(){
        if($('#waktu').val() == '')
        {
            alert('Silahkan pilih waktu terlebih dahulu!');
        }else{
            let waktu = $('#waktu').val();
            $.ajax({
                url: '{{ route("absen.index") }}/makan/'+waktu,
                type: 'GET',
                success: function (data) {
                    if(data == 'kosong'){
                        alert('Absen Makan hari ini sudah digenerate!');
                        $("#absen").load(window.location + " #absen");
                    }else{
                        alert('Absen Makan hari ini berhasil digenerate!');
                        $("#absen").load(window.location + " #absen");
                    }
                }
            });
        }
    }

    // DELETE DATA ABSEN
    function deleteData(id) {
        let conf = confirm("Apakah anda yakin data ini akan dihapus ?");
        if(conf){
            $.ajax({  
                url: '{{ route("absen.index") }}/'+id,  
                type: 'DELETE',  
                dataType: 'json', 
                success: function (data) {
                    if(data.status == 0){
                        alert(data.msg);
                    }else{
                        alert('Data berhasil dihapus.');
                        $("#absen").load(window.location + " #absen");
                    }
                }
            });
        }
    }
</script>
@endsection