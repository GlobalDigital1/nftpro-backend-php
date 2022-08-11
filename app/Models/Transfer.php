<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'from',
        'to',
        'token_id',
        'transaction_hash',
        'blockchain'
    ];
}
