<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nft extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image_url',
        'contract_address',
        'token_id',
        'owner_address',
        'creator_address',
        'transaction_hash',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_address', 'wallet_address');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_address', 'wallet_address');
    }
}
