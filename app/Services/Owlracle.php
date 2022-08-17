<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Owlracle
{
    private string $host;
    private string $key;

    public function __construct()
    {
        $this->host = config('services.owlracle.host');
        $this->key  = config('services.owlracle.key');
    }

    public function getEthGas()
    {
        return Http::get($this->host . '/eth/gas', ['apikey' => $this->key])->throw()->json();
    }

    public function getPolygonGas()
    {
        return Http::get($this->host . '/poly/gas', ['apikey' => $this->key])->throw()->json();
    }
}
