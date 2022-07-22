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
     * @var \App\Services\EtherScan
     */
    private EtherScan $etherScan;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(EtherScan $etherScan)
    {
        $this->etherScan = $etherScan;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Nft $nft)
    {
        $response = $this->etherScan->getTransactionStatus($nft->transaction_hash);

        if (!$response['isError']) {
            $nft->is_available = true;
            $nft->save();
        }
    }
}
