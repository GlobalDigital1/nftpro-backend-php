<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class EtherScan
{
    private string $host;
    private string $key;

    public function __construct()
    {
        $this->host = config('services.etherscan.host');
        $this->key = config('services.etherscan.key');
    }

    public function getTransactionStatus($transactionHash)
    {
        return Http::get($this->host, [
            'module' => 'transaction',
            'action' => 'gettxreceiptstatus',
            'txhash' => $transactionHash,
            'apikey' => $this->key,
        ])->throw()->json()['result'];
    }

    public function getTransactionDetails($transactionHash)
    {
        return Http::get($this->host, [
            'module' => 'proxy',
            'action' => 'eth_getTransactionByHash',
            'txhash' => $transactionHash,
            'apikey' => $this->key,
        ])->throw()->json()['result'];
    }
}
