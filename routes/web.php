<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/dashboard', 'web\IndexController@index')->name('home');
Route::get('/', function () {
	return redirect()->route('login');
});

//Route Petugas
Route::prefix('petugas')->group(function () {
	Route::get('/', 'web\IndexController@petugas')->name('petugas');
});

//Route Kelas
Route::prefix('kelas')->group(function () {
	Route::get('/', 'web\IndexController@kelas')->name('kelas');
});

//Route Absen
Route::prefix('absen')->group(function () {
	Route::get('/', 'web\IndexController@absen')->name('absen');

});

//Route Siswa
Route::prefix('siswa')->group(function () {
	Route::get('/', 'web\IndexController@siswa')->name('siswa');
});

//Route Tahun Ajaran
Route::prefix('th-ajaran')->group(function () {
	Route::get('/', 'web\IndexController@thAjaran')->name('th-ajaran');
});