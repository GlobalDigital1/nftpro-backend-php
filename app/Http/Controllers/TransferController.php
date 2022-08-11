<?php

namespace App\Http\Controllers;

use App\Enums\TransactionType;
use App\Http\Requests\TransferRequest;
use App\Jobs\CheckTransactionStatus;
use App\Models\Transfer;

class TransferController extends Controller
{
    public function create(TransferRequest $request, $chain)
    {
        $transfer = Transfer::query()->create([
            array_merge(
                $request->validated(),
                [
                    'from'       => $request->user()->wallet_address,
                    'blockchain' => $chain,
                ]
            ),
        ]);

        CheckTransactionStatus::dispatch($transfer->transaction_hash, $transfer->blockchain, TransactionType::transfer())
                              ->delay(now()->addSeconds(10));
    }
}
