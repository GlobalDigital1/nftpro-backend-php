<?php

namespace App\Http\Controllers;

use App\Enums\NftBlockchain;
use App\Http\Requests\MintRequest;
use App\Jobs\SyncNft;
use App\Models\Nft;
use App\Models\TokenId;
use App\Services\NftProMinter;

class MintController extends Controller
{
    private NftProMinter $minter;

    public function __construct(NftProMinter $minter)
    {
        $this->minter = $minter;
    }

    public function ether(MintRequest $request)
    {
        $data = $this->minter->mint(
            $request->wallet_address,
            $request->file('image'),
            $request->name,
            $request->description
        );

        $nft = Nft::query()->create([
            'name' => $data['pinData']['name'],
            'blockchain' => NftBlockchain::ether(),
            'description' => $data['pinData']['description'],
            'image_url' => $data['pinData']['image'],
            'token_id' =>  TokenId::firstOrFail()->latest_used,
            'contract_address' =>  $data['mintData']['to'],
            'owner_address' =>  $request->wallet_address,
            'creator_address' =>  $request->wallet_address,
            'transaction_hash' =>  $data['mintData']['hash'],
        ]);
        SyncNft::dispatch($nft)->delay(now()->addMinute());
    }
}
