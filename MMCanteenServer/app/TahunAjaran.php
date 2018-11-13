<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
        'tahun'
    ];

    public function siswa()
    {
        return $this->belongsToMany(Siswa::class);
    }
}
