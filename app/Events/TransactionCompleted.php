<?php

namespace App\Events;

use App\Enums\TransactionType;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransactionCompleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $transactionHash;
    public string $blockchain;
    public TransactionType $type;

    public function __construct(string $transactionHash, string $blockchain, TransactionType $type)
    {
        $this->transactionHash = $transactionHash;
        $this->blockchain      = $blockchain;
        $this->type            = $type;
    }
}
