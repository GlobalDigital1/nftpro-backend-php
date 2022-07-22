<?php

namespace App\Jobs;

use App\Models\Nft;
use App\Services\EtherScan;
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
    public function handle(EtherScan $etherScan)
    {
        $response = $etherScan->getTransactionStatus($this->nft->transaction_hash);

        if (!$response['isError']) {
            $this->nft->is_available = true;
            $this->nft->save();
        }
    }
}
