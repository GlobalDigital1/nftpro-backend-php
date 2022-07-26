<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PolygonScan
{
    private string $host;
    private string $key;

    public function __construct(string $host, string $key)
    {
        $this->host = $host;
        $this->key = $key;
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
}
