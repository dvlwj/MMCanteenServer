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
Route::get('/dashboard', 'HomeController@index')->name('home');
Route::get('/petugas', 'HomeController@petugas')->name('petugas');
Route::get('/kelas', 'HomeController@kelas')->name('kelas');
Route::get('/absen', 'HomeController@absen')->name('absen');
Route::get('/siswa', 'HomeController@siswa')->name('siswa');
Route::get('/th-ajaran', 'HomeController@thAjaran')->name('th-ajaran');

Route::get('/', function () {
	return redirect()->route('login');
});


