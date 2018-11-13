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
        'time', 'user_id', 'siswa_id', 'kelas', 'th_ajaran',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
