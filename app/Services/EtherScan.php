<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class EtherScan
{
    private string $host;
    private string $key;

    public function __construct(string $host, string $key)
    {
        $this->host = $host;
        $this->key = $key;
    }

    public function getLastPrice()
    {
        return Http::get($this->host, [
            'module' => 'stats',
            'action' => 'ethprice',
            'apikey' => $this->key,
        ])->json()['result'];
    }

    public function getTransactionStatus($transactionHash)
    {
        return Http::retry(20, 3000)->get($this->host, [
            'module' => 'transaction',
            'action' => 'getstatus',
            'txhash' => $transactionHash,
            'apikey' => $this->key,
        ])->throw()->json()['result'];
    }
}
