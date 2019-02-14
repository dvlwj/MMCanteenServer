<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kel_kelas', 'h_pagi_b', 'h_pagi_j', 'h_siang_b', 'h_siang_j'
    ];

}
