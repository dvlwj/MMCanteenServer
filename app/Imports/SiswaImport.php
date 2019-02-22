<?php

namespace App\Imports;

use App\Siswa;
use App\Kelas;
use App\TahunAjaran;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToCollection, WithHeadingRow
{
    /**
     * @var array
     */
    private $res = [];

    public function getStatus(): array
    {
        return $this->res;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        $err = []; $success = [];

        foreach ($rows as $row)
        {
            $pagi = $siang = $porsi_pagi = $porsi_siang = '';

            //PAGI
            if(is_string($row['pagi'])) {
                $err[] = [
                    'nis' => $row['nis'],
                    'name' => $row['name'],
                    'msg' => 'kolom Pagi tidak boleh selain 1[aktif] atau 0[non aktif]'
                ];    
            }

            if($row['pagi'] == 0) {
                $pagi = 'non aktif';
            }elseif ($row['pagi'] == 1) {
                $pagi = 'aktif';
            }else{
                $err[] = [
                    'nis' => $row['nis'],
                    'name' => $row['name'],
                    'msg' => 'kolom Pagi tidak boleh selain 1[aktif] atau 0[non aktif]'
                ];
            }

            //SIANG
            if(is_string($row['siang'])) {
                $err[] = [
                    'nis' => $row['nis'],
                    'name' => $row['name'],
                    'msg' => 'kolom Siang tidak boleh selain 1[aktif] atau 0[non aktif]'
                ];    
            }

            if($row['siang'] == 0) {
                $siang = 'non aktif';
            }elseif($row['siang'] == 1) {
                $siang = 'aktif';
            }else{
                $err[] = [
                    'nis' => $row['nis'],
                    'name' => $row['name'],
                    'msg' => 'kolomg Siang tidak boleh selain 1[aktif] atau 0[non aktif]'
                ];
            }

            //PORSI PAGI
            if(is_string($row['porsi_pagi'])) {
                $err[] = [
                    'nis' => $row['nis'],
                    'name' => $row['name'],
                    'msg' => 'kolom Pagi tidak boleh selain 1[aktif] atau 0[non aktif]'
                ];    
            }

            if($row['porsi_pagi'] == 0) {
                $porsi_pagi = '0';
            }elseif ($row['porsi_pagi'] == 1) {
                $porsi_pagi = '1';
            }else{
                $err[] = [
                    'nis' => $row['nis'],
                    'name' => $row['name'],
                    'msg' => 'kolom Porsi Pagi tidak boleh selain 1[aktif] atau 0[non aktif]'
                ];
            }

            //PORSI SIANG
            if(is_string($row['porsi_siang'])) {
                $err[] = [
                    'nis' => $row['nis'],
                    'name' => $row['name'],
                    'msg' => 'kolom Porsi Siang tidak boleh selain 1[aktif] atau 0[non aktif]'
                ];    
            }

            if($row['porsi_siang'] == 0) {
                $porsi_siang = '0';
            }elseif ($row['porsi_siang'] == 1) {
                $porsi_siang = '1';
            }else{
                $err[] = [
                    'nis' => $row['nis'],
                    'name' => $row['name'],
                    'msg' => 'kolom Porsi Siang tidak boleh selain 1[aktif] atau 0[non aktif]'
                ];
            }

            //KELAS_ID
            if(is_string($row['kelas_id'])) {
                $err[] = [
                    'nis' => $row['nis'],
                    'name' => $row['name'],
                    'msg' => 'kolom kelas_id tidak boleh selain angka'
                ];
            }
            if(!Kelas::where('id',$row['kelas_id'])->first()) {
                $err[] = [
                    'nis' => $row['nis'],
                    'name' => $row['name'],
                    'msg' => 'kelas_id tidak terdaftar'
                ];
            }

            //TAHUN_AJARAN_ID
            if(is_string($row['th_ajaran_id'])) {
                $err[] = [
                    'nis' => $row['nis'],
                    'name' => $row['name'],
                    'msg' => 'kolom th_ajaran_id tidak boleh selain angka'
                ];
            }
            if(!TahunAjaran::where('id',$row['th_ajaran_id'])->first()) {
                $err[] = [
                    'nis' => $row['nis'],
                    'name' => $row['name'],
                    'msg' => 'th_ajaran_id tidak terdaftar'
                ];
            }

            // Check NIS
            if (!Siswa::where('nis', $row['nis'])->first()) {
                if(!is_string($row['pagi']) || !is_string($row['siang']) || !is_string($row['kelas_id'] || !is_string($row['th_ajaran_id']))) {
                    if(Kelas::where('id',$row['kelas_id'])->first() && TahunAjaran::where('id',$row['th_ajaran_id'])->first()) {
                        if(($row['pagi'] == 0 || $row['pagi'] == 1) && ($row['siang'] == 0 || $row['siang'] == 1)) {
                                if(($row['porsi_pagi'] == 0 || $row['porsi_pagi'] == 1) && ($row['porsi_siang'] == 0 || $row['porsi_siang'] == 1)){
                                    $success[] = [
                                        'nis' => $row['nis'],
                                        'name' => $row['name'],
                                        'msg' => 'success'
                                    ];

                                    Siswa::create([
                                        'nis' => $row['nis'],
                                        'name' => $row['name'],
                                        'no_hp' => $row['no_hp'],
                                        'kelas_id' => $row['kelas_id'],
                                        'th_ajaran_id' => $row['th_ajaran_id'],
                                        'pagi' => $pagi,
                                        'siang' => $siang,
                                        'porsi_pagi' => $porsi_pagi,
                                        'porsi_siang' => $porsi_siang
                                    ]);
                                    
                                }
                        }
                    }
                }
            }else{
                $err[] = [
                    'nis' => $row['nis'],
                    'name' => $row['name'],
                    'msg' => 'nis sudah ada'
                ];
            }
        }

        $res = [
            'success' => $success,
            'error' => $err
        ];

        // dd($res);
        
        $this->res = $res;
    }
}