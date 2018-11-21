<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'middleware' => 'cors'], function() {
    // Petugas
    Route::apiResource('petugas', 'PetugasController');

    // Siswa
    Route::resource('siswa', 'SiswaController')->except(['index', 'create', 'edit']);
    Route::get('siswa/{kelas_id}/{th_ajaran_id}', 'SiswaController@listSiswa')->name('siswa.listSiswa');

    // Kelas
    Route::apiResource('kelas', 'KelasController');

    //Tahun Ajaran
    Route::apiResource('th-ajaran', 'TahunAjaranController');

    // Absen
    Route::post('absen', 'AbsenController@store')->name('absen.store');
    Route::post('absen/{kelas}/{th_ajaran}/{bulan}/{tahun}', 'AbsenController@listAbsen')->name('absen.listAbsen');
    
    // Auth User    
    Route::post('user/signin', ['uses' => 'AuthController@signin'])->name('user.signin');
});
