<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SikawanUser extends Model
{
    protected $connection = 'sikawan';
    protected $table = 'users';

    protected $fillable = [
        'username',
        'email',
        'password'
    ];

    public $timestamps = false;
}