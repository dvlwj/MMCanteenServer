<?php

namespace App\Imports;

use App\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Siswa([
            'nis' => $row[0],
            'name' => $row[1],
            'no_hp' => $row[2],
            'kelas_id' => $row[3],
            'th_ajaran_id' => $row[4],
            'pagi' => $row[5],
            'siang' => $row[6]
        ]);
    }
}
