<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'harga_id'
    ];

    public function siswa()
    {
        return $this->belongsToMany(Siswa::class);
    }

    public function harga()
    {
        return $this->belongsTo(Harga::class);
    }
}
