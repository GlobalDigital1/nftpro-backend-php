<?php

namespace App\Jobs;

use App\Enums\NftBlockchain;
use App\Enums\TransactionType;
use App\Events\TransactionCompleted;
use App\Services\EtherScan;
use App\Services\PolygonScan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckTransactionStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $transactionHash;
    private string $blockchain;
    private TransactionType $type;

    public function __construct(string $transactionHash, string $blockchain, TransactionType $type)
    {
        $this->transactionHash = $transactionHash;
        $this->blockchain = $blockchain;
        $this->type = $type;
    }

    public function handle(EtherScan $etherScan, PolygonScan $polygonScan)
    {
        if (NftBlockchain::from($this->blockchain)->equals(NftBlockchain::eth())) {
            $response = $etherScan->getTransactionStatus($this->transactionHash);
        } else {
            $response = $polygonScan->getTransactionStatus($this->transactionHash);
        }
        if (!isset($response['status']) || $response['status'] == '') {
            self::dispatch($this->transactionHash, $this->blockchain, $this->type)->delay(now()->addSeconds(10));
            return;
        }

        if ($response['status'] == '1') {
            TransactionCompleted::dispatch($this->transactionHash, $this->blockchain, $this->type);
        }
    }
}
