<?php
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', function () {
	return redirect()->route('login');
});
Route::get('/dashboard', 'web\IndexController@index')->name('home');

//Route Petugas
Route::resource('petugas', 'web\PetugasController')->except('edit');

//Route Kelas
Route::resource('kelas', 'web\KelasController')->except('edit');

//Route Absen
Route::resource('absen', 'web\AbsenController')->except('edit');

//Route Siswa
Route::resource('siswa', 'web\SiswaController')->except('edit');

//Route Tahun Ajaran
Route::resource('th-ajaran', 'web\TahunAjaranController')->except('edit');
