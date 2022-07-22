<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LoginAttempt extends Model
{
    protected $fillable = [
        'wallet_address',
        'message'
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    protected static function booted()
    {
        static::creating(function (LoginAttempt $attempt){
            $attempt->id = Str::uuid();
        });
    }
}
