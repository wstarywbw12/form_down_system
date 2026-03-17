<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SikawanUser extends Model
{
    protected $connection = 'sikawan';
    protected $table = 'users';

    protected $fillable = [
        'pegawai_id',
        'username',
        'email',
        'password'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public $timestamps = false;
}