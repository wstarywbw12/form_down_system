<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
        'jenis_id',
        'keterangan',
        'file'
    ];

    public function jenis()
    {
        return $this->belongsTo(Jenis::class);
    }
}