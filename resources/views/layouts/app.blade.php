<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kantin Maitreya') }}|@yield('title')</title>

    <!-- logo -->
    <link rel="icon" type="image/ico" href="{{ asset('img/logo.png') }}" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Kantin Maitreya') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @else
                            @if(Auth::user()->role == 'admin')
                                <li class="{{request()->path() == 'petugas' ? 'active' : ''}}"><a href="{{ route('petugas.index') }}">Petugas</a></li>
                                <li class="{{request()->path() == 'harga' ? 'active' : ''}}"><a href="{{ route('harga.index') }}">Harga Makan</a></li>
                                <li class="{{request()->path() == 'kelas' ? 'active' : ''}}"><a href="{{ route('kelas.index') }}">Kelas</a></li>
                                <li class="{{request()->path() == 'th-ajaran' ? 'active' : ''}}"><a href="{{ route('th-ajaran.index') }}">Tahun Ajaran</a></li>
                            @endif
                            <li class="{{request()->path() == 'siswa' ? 'active' : ''}}"><a href="{{ route('siswa.index') }}">Siswa</a></li>
                            <li class="{{request()->path() == 'absen' ? 'active' : ''}}"><a href="{{ route('absen.index') }}">Absen</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                    {{ Auth::user()->username }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    @if(Auth::user())
                                    <li>
                                        <a href="#" data-toggle="modal" data-target="#changePassword">Change Password</a>
                                    </li>
                                    @endif
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
        
        @if(Auth::user())
        <!-- MODAL EDIT -->
        <div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="changePasswordCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="changePasswordCenterTitle">Form Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="newPassword" class="col-form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword">
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="changePassword('{{ Auth::user()->id }}')">Save</button>
              </div>
            </div>
          </div>
        </div>
        @endif
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
    </script>
    
    @if(Auth::user())
    <script>
        $('#changePassword').bind('keydown', function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
            }
        });

        // GET DATA PETUGAS
        function changePassword(id) {
            if($('#newPassword').val() == ''){
                alert('Password tidak boleh kosong');
            }else if($('#newPassword').val().length < 6){
                alert('Password tidak boleh kurang dari 6 karakter!');
            }else{
                $.ajax({  
                    url: '{{ route("petugas.index") }}/'+id,  
                    type: 'PATCH',  
                    dataType: 'json',  
                    data: {
                        password: $('#newPassword').val()
                    },  
                    success: function (data) {
                        if(data.status == 0){
                            alert(data.msg);
                        }else{
                            alert('Password berhasil diubah.');
                            window.location.href="{{ route('home') }}";
                        }
                    }
                });
            }
        }
    </script>
    @endif
    
    @yield('script')
</body>
</html>
