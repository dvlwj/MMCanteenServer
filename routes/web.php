<?php
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['prefix' => '/', 'middleware' => 'auth'], function() {
	Route::get('/', function () {
		return redirect()->route('login');
	});
	Route::get('/dashboard', 'web\IndexController@index')->name('home');

	//Route Petugas
	Route::resource('petugas', 'web\PetugasController')->except(['edit', 'create']);

	// Route Harga Makan
	Route::resource('harga', 'web\HargaController')->except(['edit', 'create']);

	//Route Kelas
	Route::resource('kelas', 'web\KelasController')->except(['edit', 'create']);

	//Route Siswa
	Route::resource('siswa', 'web\SiswaController')->except(['edit', 'create']);
	Route::get('siswa/qr/{id}', 'web\SiswaController@qr')->name('siswa.qrcode');

	//Route Tahun Ajaran
	Route::resource('th-ajaran', 'web\TahunAjaranController')->except(['edit', 'create']);
	
	//Route Absen
	Route::get('absen', 'web\AbsenController@index')->name('absen.index');
	Route::get('absen/makan/{status}', 'web\AbsenController@makan')->name('absen.makan');
	Route::delete('absen/{id}', 'web\AbsenController@destroy')->name('absen.destroy');

	//Route Report
	Route::get('report/{nis}', 'web\ReportController@index')->name('report.index');
});
