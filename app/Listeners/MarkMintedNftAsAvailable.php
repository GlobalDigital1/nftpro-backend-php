<?php

namespace App\Listeners;

use App\Enums\TransactionType;
use App\Events\TransactionCompleted;
use App\Models\Nft;
use Illuminate\Contracts\Queue\ShouldQueue;

class MarkMintedNftAsAvailable implements ShouldQueue
{
    public function handle(TransactionCompleted $event)
    {
        if (!$event->type->equals(TransactionType::mint())) {
            return;
        }

        Nft::query()
           ->whereTransactionHash($event->transactionHash)
           ->whereBlockchain($event->blockchain)
           ->update([
               'is_available' => true,
           ]);
    }
}
