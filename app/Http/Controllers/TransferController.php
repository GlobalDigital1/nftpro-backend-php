<?php

namespace App\Http\Controllers;

use App\Enums\TransactionType;
use App\Http\Requests\TransferRequest;
use App\Jobs\CheckTransactionStatus;
use App\Models\Nft;
use App\Models\Transfer;

class TransferController extends Controller
{
    public function create(TransferRequest $request, $chain)
    {
        $nft = Nft::query()->whereTokenId($request->token_id)->available()->firstOrFail();

        $transfer = Transfer::query()->create(
            array_merge(
                $request->validated(),
                [
                    'from'       => $request->user()->wallet_address,
                    'blockchain' => $chain,
                ]
            ),
        );

        $nft->is_available = false;
        $nft->save();

        CheckTransactionStatus::dispatch($transfer->transaction_hash, $transfer->blockchain, TransactionType::transfer())
                              ->delay(now()->addSeconds(10));
    }
}
