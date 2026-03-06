<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'nama',
        'alamat',
        'pihak',
        'nominal',
    ];

    protected function casts(): array
    {
        return [
            'nominal' => 'integer',
        ];
    }
}
