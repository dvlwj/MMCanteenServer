<?php
Auth::routes();
Route::get('/dashboard', 'web\IndexController@index')->name('home');
Route::get('/', function () {
	return redirect()->route('login');
});

//Route Petugas
Route::resource('petugas', 'web\PetugasController');

//Route Kelas
Route::resource('kelas', 'web\KelasController');

//Route Absen
Route::resource('absen', 'web\AbsenController');

//Route Siswa
Route::resource('siswa', 'web\SiswaController');

//Route Tahun Ajaran
Route::resource('th-ajaran', 'web\TahunAjaranController');
