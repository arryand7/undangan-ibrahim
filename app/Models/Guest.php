<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = [
        'nama',
        'jumlah_hadir',
        'status_hadir',
        'pesan',
    ];
}
