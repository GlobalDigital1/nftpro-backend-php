<?php

namespace App\Listeners;

use App\Enums\TransactionType;
use App\Events\TransactionCompleted;
use App\Models\Nft;
use Illuminate\Contracts\Queue\ShouldQueue;

class MarkNftAsAvailable implements ShouldQueue
{
    public function handle(TransactionCompleted $event)
    {
        if (!$event->type->equals(TransactionType::mint())) {
            return;
        }

        $nft = Nft::query()->whereTransactionHash($event->transactionHash)
                  ->whereBlockchain($event->blockchain)
                  ->notAvailable()
                  ->firstOrFail();

        $nft->is_available = true;
        $nft->save();
    }
}
