<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FcmToken extends Model
{
    protected $fillable = [
        'device_id',
        'token',
    ];
}
