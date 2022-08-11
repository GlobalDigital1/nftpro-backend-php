<?php

namespace App\Jobs;

use App\Enums\NftBlockchain;
use App\Events\TransactionCompleted;
use App\Models\Nft;
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


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $transactionHash, string $blockchain)
    {
        $this->transactionHash = $transactionHash;
        $this->blockchain = $blockchain;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(EtherScan $etherScan, PolygonScan $polygonScan)
    {
        if (NftBlockchain::from($this->blockchain)->equals(NftBlockchain::eth())) {
            $response = $etherScan->getTransactionStatus($this->transactionHash);
        } else {
            $response = $polygonScan->getTransactionStatus($this->transactionHash);
        }
        if (!isset($response['status']) || $response['status'] == '') {
            self::dispatch($this->transactionHash, $this->blockchain)->delay(now()->addSeconds(10));
            return;
        }


        if ($response['status'] == '1') {
            TransactionCompleted::dispatch($this->transactionHash, $this->blockchain);
        }
    }
}
