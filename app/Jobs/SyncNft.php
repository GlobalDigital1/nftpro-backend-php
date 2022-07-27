<?php

namespace App\Jobs;

use App\Enums\NftBlockchain;
use App\Models\Nft;
use App\Services\EtherScan;
use App\Services\PolygonScan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncNft implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \App\Models\Nft
     */
    private Nft $nft;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Nft $nft)
    {
        $this->nft = $nft;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(EtherScan $etherScan, PolygonScan $polygonScan)
    {
        if (NftBlockchain::from($this->nft->blockchain)->equals(NftBlockchain::eth())) {
            $response = $etherScan->getTransactionStatus($this->nft->transaction_hash);
        } else {
            $response = $polygonScan->getTransactionStatus($this->nft->transaction_hash);
        }
        if (!isset($response['status']) || $response['status'] == '') {
            self::dispatch($this->nft)->delay(now()->addSeconds(10));
            return;
        }

        if ($response['status'] == '1') {
            $this->nft->is_available = true;
            $this->nft->save();
        }
    }
}
