@extends('layouts.app')

@section('title')
{{ request()->path() }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Siswa</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(Auth::user()->role == 'admin')
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSiswa">
                          Tambah Siswa +
                        </button>
                        <br><br>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#importSiswa">
                          Import Excel
                        </button>
                        <hr>
                        <select class="selectpicker" id="k" data-size="5">
                            <option value="">Pilih Kelas</option>
                            @foreach($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->name }}</option>
                            @endforeach
                        </select>
                        <select class="selectpicker" id="ta" data-size="5">
                            <option value="">Pilih Tahun Ajaran</option>
                            @foreach($thAjaran as $t)
                            <option value="{{ $t->id }}">{{ $t->tahun }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-info" onclick="generateQr()">Generate QR Code</button>
                        <hr>
                    @endif

                    <table id="siswa" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">NIS</th>
                                <th class="text-center">Nama Siswa</th>
                                <th class="text-center">No HP</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">Tahun Ajaran</th>
                                <th class="text-center">Pagi</th>
                                <th class="text-center">Porsi Pagi</th>
                                <th class="text-center">Siang</th>
                                <th class="text-center">Porsi Siang</th>
                                @if(Auth::user()->role == 'admin')
                                    <th class="text-center" width="250px">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php $n=1 @endphp
                            @foreach($siswa as $data)
                            <tr>
                                <td class="text-center">{{$n++}}</td>
                                <td>{{ $data->nis }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->no_hp }}</td>
                                <td class="text-center">{{ $data->kelas_name->name }}</td>
                                <td class="text-center">{{ $data->th_ajaran_name->tahun }}</td>
                                <td class="text-center">
                                    @if($data->pagi == 'aktif')
                                    <span class="label label-success">{{ $data->pagi }}</span>
                                    @else
                                    <span class="label label-danger">{{ $data->pagi }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($data->porsi_pagi == 0)
                                    <span class="label label-info">Biasa</span>
                                    @else
                                    <span class="label label-warning">Jumbo</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($data->siang == 'aktif')
                                    <span class="label label-success">{{ $data->siang }}</span>
                                    @else
                                    <span class="label label-danger">{{ $data->siang }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($data->porsi_siang == 0)
                                    <span class="label label-info">Biasa</span>
                                    @else
                                    <span class="label label-warning">Jumbo</span>
                                    @endif
                                </td>
                                @if(Auth::user()->role == 'admin')
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm" onclick="qrCode('{{ $data->id }}')">
                                          Qr Code
                                        </button>
                                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editSiswa" onclick="getData('{{ $data->id }}')">
                                          Edit
                                        </button>
                                        <a href="{{route('report.index',$data->nis)}}" class="btn btn-success btn-sm">
                                          Report
                                        </a>
                                        <button class="btn btn-danger btn-sm" onclick="deleteData('{{ $data->id }}')">Delete</button>
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

    <!-- MODAL ADD -->
    <div class="modal fade" id="addSiswa" tabindex="-1" role="dialog" aria-labelledby="addSiswaCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content"> 
          <div class="modal-header">
            <h5 class="modal-title" id="addSiswaCenterTitle">Form Tambah Data Siswa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="nis" class="col-form-label">NIS</label>
                    <input type="text" class="form-control" id="nis" placeholder="Nomor Induk Siswa">
                </div>
                <div class="form-group">
                    <label for="namaSiswa" class="col-form-label">Nama Siswa</label>
                    <input type="text" class="form-control" id="namaSiswa" placeholder="Nama Lengkap Siswa">
                </div>
                <div class="form-group">
                    <label for="nohp" class="col-form-label">No HP</label>
                    <input type="text" class="form-control" id="nohp" placeholder="Nomor HP Siswa">
                </div>
                <div class="form-group">
                    <label for="kelasID">Kelas</label>
                    <select id="kelasID" class="form-control">
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="thAjaranID">Tahun Ajaran</label>
                    <select id="thAjaranID" class="form-control">
                        @foreach($thAjaran as $th)
                            <option value="{{ $th->id }}">{{ $th->tahun }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="statusPagi">Pagi</label>
                    <select id="statusPagi" class="form-control">
                        <option value="aktif">Aktif</option>
                        <option value="non aktif">Non Aktif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="statusSiang">Siang</label>
                    <select id="statusSiang" class="form-control">
                        <option value="aktif">Aktif</option>
                        <option value="non aktif">Non Aktif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="porsiPagi">Porsi Pagi</label>
                    <select id="porsiPagi" class="form-control">
                        <option value="0">Biasa</option>
                        <option value="1">Jumbo</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="porsiSiang">Porsi Siang</label>
                    <select id="porsiSiang" class="form-control">
                        <option value="0">Biasa</option>
                        <option value="1">Jumbo</option>
                    </select>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal" id="saveAdd">Save</button>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL EDIT -->
    <div class="modal fade" id="editSiswa" tabindex="-1" role="dialog" aria-labelledby="editSiswaCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editSiswaCenterTitle">Form Edit Data Siswa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
                <input type="hidden" class="form-control" id="editID">
                <div class="form-group">
                    <label for="editNis" class="col-form-label">NIS</label>
                    <input type="text" class="form-control" id="editNis" placeholder="Nomor Induk Siswa">
                </div>
                <div class="form-group">
                    <label for="editNamaSiswa" class="col-form-label">Nama Siswa</label>
                    <input type="text" class="form-control" id="editNamaSiswa" placeholder="Nama Lengkap Siswa">
                </div>
                <div class="form-group">
                    <label for="editNohp" class="col-form-label">No HP</label>
                    <input type="text" class="form-control" id="editNohp" placeholder="Nomor HP Siswa">
                </div>
                <div class="form-group">
                    <label for="editKelasID">Kelas</label>
                    <select id="editKelasID" class="form-control">
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="editThAjaranID">Tahun Ajaran</label>
                    <select id="editThAjaranID" class="form-control">
                        @foreach($thAjaran as $th)
                            <option value="{{ $th->id }}">{{ $th->tahun }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="editStatusPagi">Pagi</label>
                    <select id="editStatusPagi" class="form-control">
                        <option value="aktif">Aktif</option>
                        <option value="non aktif">Non Aktif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editStatusSiang">Siang</label>
                    <select id="editStatusSiang" class="form-control">
                        <option value="aktif">Aktif</option>
                        <option value="non aktif">Non Aktif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editPorsiPagi">Porsi Pagi</label>
                    <select id="editPorsiPagi" class="form-control">
                        <option value="0">Biasa</option>
                        <option value="1">Jumbo</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editPorsiSiang">Porsi Siang</label>
                    <select id="editPorsiSiang" class="form-control">
                        <option value="0">Biasa</option>
                        <option value="1">Jumbo</option>
                    </select>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal" id="saveEdit">Save</button>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL IMPORT -->
    <div class="modal fade" id="importSiswa" tabindex="-1" role="dialog" aria-labelledby="importSiswaCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="importSiswaCenterTitle">Form Import Data Siswa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Silahkan download format file excel terlebih dahulu sebelum import data.
            <a href="{{ asset('file/format.xlsx') }}" class="btn btn-warning" download>Download format excel</a>
            <br><br>
            <form action="{{route('siswa.import')}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="importData" class="col-form-label">Import file excel</label>
                    <input type="file" class="form-control" name="importData">
                    <span class="label label-danger">Pastikan file yang Anda import sesuai dan memiliki format yang benar.</span>
                </div>
                <input type="submit" class="btn btn-success" value="Submit">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#siswa').DataTable();
    });

    $('#addSiswa').bind('keydown', function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    });

    $('#editSiswa').bind('keydown', function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    });

    function getData(id) {
        $.get('{{ route("siswa.index") }}/'+id, function(data) {
            if(data.status == 0){
                alert('Data Not Found');
            } else {
                $('#editNis').val(data.nis);
                $('#editNamaSiswa').val(data.name);
                $('#editNohp').val(data.no_hp);
                $('#editKelasID').val(data.kelas_id); 
                $('#editThAjaranID').val(data.th_ajaran_id);
                $('#editStatusPagi').val(data.pagi);
                $('#editStatusSiang').val(data.siang);
                $('#editPorsiPagi').val(data.porsi_pagi);
                $('#editPorsiSiang').val(data.porsi_siang);
                $('#editID').val(data.id);
            }
        });
    }

    // TAMBAH DATA Siswa
    $('#saveAdd').click(function(e) {
        e.preventDefault();
        if($('#nis').val() == '' || $('#namaSiswa').val() == '' || $('#kelasID').val() == '' || $('#thAjaranID').val() == '' || $('#nohp').val() == '') {
            alert("Data tidak boleh ada yang kosong!");
        } else if (isNaN($('#nis').val())){
            alert("NIS harus berupa angka!");
        } else if (isNaN($('#nohp').val())) {
            alert("No HP harus berupa angka!");
        } else {
            $.ajax({  
                url: '{{ route("siswa.index") }}',  
                type: 'POST',  
                dataType: 'json',  
                data: {
                    nis: $('#nis').val(),
                    name: $('#namaSiswa').val(),
                    no_hp: $('#nohp').val(),
                    kelas_id: $('#kelasID').val(),
                    th_ajaran_id: $('#thAjaranID').val(),
                    pagi: $('#statusPagi').val(),
                    siang: $('#statusSiang').val(),
                    porsi_pagi: $('#porsiPagi').val(),
                    porsi_siang: $('#porsiSiang').val()
                },  
                success: function (data) {
                    if(data.status == 0) {
                        alert(data.msg);
                    } else {
                        alert('Data berhasil ditambah.');
                        refreshForm();
                        $("#siswa").load(window.location + " #siswa");
                    }
                }
            });
        }
    });

    // EDIT DATA Siswa
    $('#saveEdit').click(function(e) {
        e.preventDefault();

        if($('#editNis').val() == '' || $('#editNamaSiswa').val() == '' || $('#editNohp').val() == '') {
            alert("Data tidak boleh ada yang kosong!");
        } else if (isNaN($('#editNis').val())){
            alert("NIS harus berupa angka!");
        } else if (isNaN($('#editNohp').val())) {
            alert("No HP harus berupa angka!");
        } else {
            $.ajax({  
                url: '{{ route("siswa.index") }}/'+$('#editID').val(),  
                type: 'PATCH',  
                dataType: 'json',  
                data: {
                    nis: $('#editNis').val(),
                    name: $('#editNamaSiswa').val(),
                    no_hp: $('#editNohp').val(),
                    kelas_id: $('#editKelasID').val(),
                    th_ajaran_id: $('#editThAjaranID').val(),
                    pagi: $('#editStatusPagi').val(),
                    siang: $('#editStatusSiang').val(),
                    porsi_pagi: $('#editPorsiPagi').val(),
                    porsi_siang: $('#editPorsiSiang').val()
                },  
                success: function (data) {
                    if(data.status == 0){
                        alert(data.msg);
                    }else{
                        alert('Data berhasil diedit.');
                        $("#siswa").load(window.location + " #siswa");
                    }
                }
            });
        }
    });

    // DELETE DATA SISWA
    function deleteData(id) {
        let conf = confirm("Apakah anda yakin data ini akan dihapus ?");
        if(conf){
            $.ajax({  
                url: '{{ route("siswa.index") }}/'+id,  
                type: 'DELETE',  
                dataType: 'json', 
                success: function (data) {
                    if(data.status == 0){
                        alert(data.msg);
                    }else{
                        alert('Data berhasil dihapus.');
                        $("#siswa").load(window.location + " #siswa");
                    }
                }
            });
        }
    }

    //REFRESH FORM
    function refreshForm() {
        $('#nis').val('');
        $('#namaSiswa').val('');
        $('#nohp').val('');
        $('#kelasID').val('');
        $('#thAjaranID').val('');
        $('#statusPagi').val('');
        $('#statusSiang').val('');
        $('#porsiPagi').val('');
        $('#porsiSiang').val('');
    }

    //GENERATE QR CODE BY CLASS
    function generateQr() {
        let kelas = $('#k').val();
        let thAjaran = $('#ta').val();

        if(kelas == '' || thAjaran == ''){
            alert("Kelas dan Tahun Ajaran harus dipilih!");
        }else{
            window.location = '{{ route("siswa.index") }}/qr/'+kelas+'/'+thAjaran;
        }
    }

    //GENERATE QR CODE BY ID SISWA
    function qrCode(id) {
            window.location = '{{ route("siswa.index") }}/qrone/'+id;
    }
</script>
@endsection