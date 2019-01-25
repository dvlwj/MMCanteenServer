<?php

namespace App\Imports;

use App\Siswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            // Check NIS
            if (!Siswa::where('nis', $row['nis'])->first()) {
                $pagi = ''; $siang = '';

                if($row['pagi'] == 0) {
                    $pagi = 'non aktif';
                }elseif ($row['pagi'] == 1) {
                    $pagi = 'aktif';
                }

                if($row['siang'] == 0) {
                    $siang = 'non aktif';
                }elseif($row['siang'] == 1) {
                    $siang = 'non aktif';
                }
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
    }
}
