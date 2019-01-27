<?php

namespace App\Imports;

use App\Siswa;
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
        $err = [];
        $success = [];

        foreach ($rows as $row)
        {
            $pagi = ''; $siang = '';

            if(is_string($row['pagi'])) {
                $err[] = [
                    'nis' => $row['nis'],
                    'name' => $row['name'],
                    'msg' => 'kolom Pagi tidak boleh selain 1[aktif] atau 0[non aktif]'
                ];    
            }elseif(is_string($row['siang'])) {
                $err[] = [
                    'nis' => $row['nis'],
                    'name' => $row['name'],
                    'msg' => 'kolom Siang tidak boleh selain 1[aktif] atau 0[non aktif]'
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

            if($row['siang'] == 0) {
                $siang = 'non aktif';
            }elseif($row['siang'] == 1) {
                $siang = 'non aktif';
            }else{
                $err[] = [
                    'nis' => $row['nis'],
                    'name' => $row['name'],
                    'msg' => 'kolomg Siang tidak boleh selain 1[aktif] atau 0[non aktif]'
                ];
            }

            // Check NIS
            if (!Siswa::where('nis', $row['nis'])->first()) {
                if(!is_string($row['pagi']) || !is_string($row['pagi'])) {
                    if(($row['pagi'] == 0 || $row['pagi'] == 1) && ($row['siang'] == 0 || $row['siang'] == 1)) {
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
                            'siang' => $siang
                        ]);
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