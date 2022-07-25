<?php

namespace App\Services;

use App\Models\TokenId;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class NftProMinter
{
    private $host;

    public function __construct($host)
    {
        $this->host = $host;
    }

    public function mint(string $wallet_address, UploadedFile $image, string $name, string $description)
    {
        return Http::attach('image', $image->getContent(), $image->getFilename())
                   ->post($this->host . '/mint', [
                       'accountId'   => $wallet_address,
                       'tokenId'     => $this->getTokenId(),
                       'name'        => $name,
                       'description' => $description,
                   ])->json();
    }

    public function transfer(string $from, string $to, $tokenId)
    {
        return Http::post($this->host . '/mint', [
            'from'    => $from,
            'to'      => $to,
            'tokenId' => $tokenId,
        ])->json();
    }

    private function getTokenId()
    {
        $tokenId = TokenId::query()->first();
        $tokenId->latest_used++;
        $tokenId->save();
        return $tokenId->latest_used;
    }
}
