<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferNftRequest;
use App\Services\NftProMinter;

class TransferNftController extends Controller
{
    private NftProMinter $minter;

    public function __construct(NftProMinter $minter)
    {
        $this->minter = $minter;
    }

    public function __invoke(TransferNftRequest $request, $id)
    {
        $nft = $request->user()->nfts()->findOrFail($id);
        $this->minter->transfer($request->user()->wallet_address,$request->to,$nft->token_id);
    }
}
