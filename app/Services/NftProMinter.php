<?php

namespace App\Services;

use App\Models\TokenId;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class NftProMinter
{
    private string $host;

    public function __construct()
    {
        $this->host = config('services.minter.host');
    }

    public function mint(string $chain, string $wallet_address, UploadedFile $image, string $name, string $description)
    {
        return Http::attach('image', $image->getContent(), $image->getFilename())
                   ->post($this->host . "/$chain/mint", [
                       'accountId'   => $wallet_address,
                       'tokenId'     => $this->getTokenId($chain),
                       'name'        => $name,
                       'description' => $description,
                   ])->json();
    }

    public function transfer(string $from, string $to, $tokenId)
    {
        return Http::post($this->host . '/transfer', [
            'from'    => $from,
            'to'      => $to,
            'tokenId' => $tokenId,
        ])->json();
    }

    private function getTokenId(string $chain)
    {
        $tokenId = TokenId::query()->whereBlockchain($chain)->first();
        $tokenId->latest_used++;
        $tokenId->save();
        return $tokenId->latest_used;
    }
}
