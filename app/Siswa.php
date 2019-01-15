<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nis', 'name', 'kelas_id', 'th_ajaran_id', 'pagi', 'siang'
    ];

    public function kelas()
    {
        return $this->hasOne(Kelas::class);
    }

    public function th_ajaran()
    {
        return $this->hasOne(TahunAjaran::class);
    }
}
