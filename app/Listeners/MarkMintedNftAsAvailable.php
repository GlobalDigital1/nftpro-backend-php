<?php

namespace App\Listeners;

use App\Enums\TransactionType;
use App\Events\TransactionCompleted;
use App\Models\Nft;
use App\Notifications\NftMinted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class MarkMintedNftAsAvailable implements ShouldQueue
{
    public function handle(TransactionCompleted $event)
    {
        if (!$event->type->equals(TransactionType::mint())) {
            return;
        }

        $nft = Nft::query()
           ->whereTransactionHash($event->transactionHash)
           ->whereBlockchain($event->blockchain)
           ->firstOrFail();

        $nft->update([
            'is_available' => true,
        ]);

        Notification::send($nft->owner, new NftMinted($nft));
    }
}
