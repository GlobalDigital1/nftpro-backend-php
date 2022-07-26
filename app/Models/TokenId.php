<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenId extends Model
{
    protected $fillable = [
        'blockchain'
    ];

    protected $table = 'token_id';

    public $timestamps = false;
}
