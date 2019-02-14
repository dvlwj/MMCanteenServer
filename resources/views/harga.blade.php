@extends('layouts.app')

@section('title')
{{ request()->path() }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Harga</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addHarga">
                      Tambah Harga +
                    </button>
                    <hr>

                    <table id="harga" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Kelompok</th>
                                <th class="text-center">Harga Pagi Biasa</th>
                                <th class="text-center">Harga Siang Jumbo</th>
                                <th class="text-center">Harga Pagi Biasa</th>
                                <th class="text-center">Harga Siang Jumbo</th>
                                @if(Auth::user()->role == 'admin')
                                    <th class="text-center">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php $n=1 @endphp
                            @foreach($harga as $data)
                            <tr>
                                <td class="text-center">{{$n++}}</td>
                                <td class="text-center">{{ $data->kel_kelas }}</td>
                                <td class="text-center"> Rp {{ number_format($data->h_pagi_b, 2, ",", ".") }}</td>
                                <td class="text-center"> Rp {{ number_format($data->h_pagi_j, 2, ",", ".") }}</td>
                                <td class="text-center"> Rp {{ number_format($data->h_siang_b, 2, ",", ".") }}</td>
                                <td class="text-center"> Rp {{ number_format($data->h_siang_j, 2, ",", ".") }}</td>
                                @if(Auth::user()->role == 'admin')
                                    <td class="text-center" width="250px">
                                        <button class="btn btn-warning" data-toggle="modal" data-target="#editHarga" onclick="getData('{{ $data->id }}')">
                                          Edit
                                        </button>
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

    <!-- MODAL ADD -->
    <div class="modal fade" id="addHarga" tabindex="-1" role="dialog" aria-labelledby="addHargaCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addHargaCenterTitle">Form Tambah Data Harga</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="kelKelas" class="col-form-label">Kelompok Kelas</label>
                    <input type="text" class="form-control" id="kelKelas" placeholder="cth: Kelas 1 dan 2">
                </div>
                <div class="form-group">
                    <label for="addHargaPagiBiasa" class="col-form-label">Harga Pagi Biasa</label>
                    <input type="number" class="form-control" id="addHargaPagiBiasa" placeholder="cth: 10000">
                </div>
                <div class="form-group">
                    <label for="addHargaPagiJumbo" class="col-form-label">Harga Pagi Jumbo</label>
                    <input type="number" class="form-control" id="addHargaPagiJumbo" placeholder="cth: 10000">
                </div>
                <div class="form-group">
                    <label for="addHargaSiangBiasa" class="col-form-label">Harga Siang Biasa</label>
                    <input type="number" class="form-control" id="addHargaSiangBiasa" placeholder="cth: 10000">
                </div>
                <div class="form-group">
                    <label for="addHargaSiangJumbo" class="col-form-label">Harga Siang Jumbo</label>
                    <input type="number" class="form-control" id="addHargaSiangJumbo" placeholder="cth: 10000">
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
    <div class="modal fade" id="editHarga" tabindex="-1" role="dialog" aria-labelledby="editHargaCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editHargaCenterTitle">Form Edit Data Harga</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
                <div class="form-group">
                    <input type="hidden" class="form-control" id="editID">
                    <label for="editKelKelas" class="col-form-label">Kelompok Kelas</label>
                    <input type="text" class="form-control" id="editKelKelas">
                </div>
                <div class="form-group">
                    <label for="editHargaPagiBiasa" class="col-form-label">Harga Pagi Biasa</label>
                    <input type="number" class="form-control" id="editHargaPagiBiasa">
                </div>
                <div class="form-group">
                    <label for="editHargaPagiJumbo" class="col-form-label">Harga Pagi Jumbo</label>
                    <input type="number" class="form-control" id="editHargaPagiJumbo">
                </div>
                <div class="form-group">
                    <label for="editHargaSiangBiasa" class="col-form-label">Harga Siang Biasa</label>
                    <input type="number" class="form-control" id="editHargaSiangBiasa">
                </div>
                <div class="form-group">
                    <label for="editHargaSiangJumbo" class="col-form-label">Harga Siang Jumbo</label>
                    <input type="number" class="form-control" id="editHargaSiangJumbo">
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
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#harga').DataTable();
    });

    $('#addHarga').bind('keydown', function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    });

    $('#editHarga').bind('keydown', function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    });

    // GET DATA KELAS
    function getData(id) {
        $.get('{{ route("harga.index") }}/'+id, function(data) {
            $('#editKelKelas').val(data.kel_kelas);
            $('#editHargaPagiBiasa').val(data.h_pagi_b);
            $('#editHargaPagiJumbo').val(data.h_pagi_j);
            $('#editHargaSiangBiasa').val(data.h_siang_b);
            $('#editHargaSiangJumbo').val(data.h_siang_j);
            $('#editID').val(data.id); 
            console.log(data);
        });
    }

    // ADD DATA KELAS
    $('#saveAdd').click(function(e) {
        e.preventDefault();
        
        if($('#kelKelas').val() == '' || $('#addHargaPagiBiasa').val() == '' || $('#addHargaPagiJumbo').val() == '' || $('#addHargaSiangBiasa').val() == '' || $('#addHargaSiangJumbo').val() == '') {
            alert("Kelompok Kelas atau Harga Makan tidak boleh kosong!");
        } else if ($('#addHargaPagiBiasa').val() != '' && isNaN($('#addHargaPagiBiasa').val()) || $('#addHargaPagiJumbo').val() != '' && isNaN($('#addHargaPagiJumbo').val()) || $('#addHargaSiangBiasa').val() != '' && isNaN($('#addHargaSiangBiasa').val()) || $('#addHargaSiangJumbo').val() != '' && isNaN($('#addHargaSiangJumbo').val())){
            alert("Harga harus berupa angka!");
        } else {
            $.ajax({  
                url: '{{ route("harga.index") }}',  
                type: 'POST',  
                dataType: 'json',  
                data: {
                    kel_kelas: $('#kelKelas').val(),
                    h_pagi_b: $('#addHargaPagiBiasa').val(),
                    h_pagi_j: $('#addHargaPagiJumbo').val(),
                    h_siang_b: $('#addHargaSiangBiasa').val(),
                    h_siang_j: $('#addHargaSiangJumbo').val(),
                },  
                success: function (data) {
                    if(data.status == 0) {
                        alert(data.msg);
                    } else {
                        alert('Data berhasil ditambah.');
                        refreshForm();
                        $("#harga").load(window.location + " #harga");
                    }
                }
            });
        }
    });

    // EDIT DATA KELAS
    $('#saveEdit').click(function(e) {
        e.preventDefault();

        if($('#editHargaPagiBiasa').val() != '' && isNaN($('#editHargaPagiBiasa').val()) || $('#editHargaPagiJumbo').val() != '' && isNaN($('#editHargaPagiJumbo').val()) || $('#editHargaSiangBiasa').val() != '' && isNaN($('#editHargaSiangBiasa').val() || $('#editHargaSiangJumbo').val() != '' && isNaN($('#editHargaSiangJumbo').val()))){
            alert("Harga harus berupa angka!");
        } else {
            $.ajax({  
                url: '{{ route("harga.index") }}/'+$('#editID').val(),  
                type: 'PATCH',  
                dataType: 'json',  
                data: {
                    kel_kelas: $('#editKelKelas').val(),
                    h_pagi_b: $('#editHargaPagiBiasa').val(),
                    h_pagi_j: $('#editHargaPagiJumbo').val(),
                    h_siang_b: $('#editHargaSiangBiasa').val(),
                    h_siang_j: $('#editHargaSiangJumbo').val()
                },  
                success: function (data) {
                    if(data.status == 0){
                        alert(data.msg);
                    }else{
                        alert('Data berhasil diedit.');
                        $("#harga").load(window.location + " #harga");
                    }
                }
            });
        }
    });

    // DELETE DATA KELAS
    function deleteData(id) {
        let conf = confirm("Jika anda menghapus data ini, maka data Kelas dan Siswa yang terhubung dengan kelompok harga ini akan terhapus. Apakah Anda yakin data ini akan dihapus ?");
        if(conf){
            $.ajax({  
                url: '{{ route("harga.index") }}/'+id,  
                type: 'DELETE',  
                dataType: 'json', 
                success: function (data) {
                    if(data.status == 0){
                        alert(data.msg);
                    }else{
                        alert('Data berhasil dihapus.');
                        $("#harga").load(window.location + " #harga");
                    }
                }
            });
        }
    }

    function refreshForm() {
        $('#kelKelas').val('');
        $('#addHargaPagiBiasa').val('');
        $('#addHargaPagiJumbo').val('');
        $('#addHargaSiangBiasa').val('');
        $('#addHargaSiangJumbo').val('');
    }
</script>
@endsection