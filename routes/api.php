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

Route::group(['prefix' => 'v1', 'middleware' => ['cors', 'jwt.auth']], function() {
    // Petugas
    Route::patch('petugas', 'PetugasController@update')->name('petugas.update');

    // Siswa
    Route::patch('siswa/{id}', 'SiswaController@update')->name('siswa.update');
    Route::get('siswa/{kelas_id}/{th_ajaran_id}', 'SiswaController@listSiswa')->name('siswa.listSiswa');
    Route::get('siswa/kelas', 'SiswaController@listKelas')->name('siswa.kelas');
    Route::get('siswa/th-ajaran', 'SiswaController@listTahunAjaran')->name('siswa.th-ajaran');

    // Absen
    Route::post('absen', 'AbsenController@store')->name('absen.store');
    Route::get('absen/{kelas}/{th_ajaran}/{bulan}/{tahun}', 'AbsenController@listAbsen')->name('absen.listAbsen'); 
});

    // Auth User    
    Route::post('v1/user/signin', ['uses' => 'AuthController@signin'])->name('user.signin');
