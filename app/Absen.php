<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'siswa_id', 'time', 'status',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function siswa()
    {
        return $this->belongsToMany(Siswa::class);
    }
}
