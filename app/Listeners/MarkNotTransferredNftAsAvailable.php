<?php

namespace App\Listeners;

use App\Enums\TransactionType;
use App\Events\TransactionFailed;
use App\Models\Nft;
use App\Models\Transfer;
use Illuminate\Contracts\Queue\ShouldQueue;

class MarkNotTransferredNftAsAvailable implements ShouldQueue
{
    public function handle(TransactionFailed $event)
    {
        if (!$event->type->equals(TransactionType::transfer())) {
            return;
        }

        $transaction = Transfer::query()->whereTransactionHash($event->transactionHash)
                               ->whereBlockchain($event->blockchain)
                               ->firstOrFail();

        Nft::query()
           ->whereBlockchain($transaction->blockchain)
           ->whereTokenId($transaction->token_id)
           ->update([
               'is_available' => true,
           ]);
    }
}
