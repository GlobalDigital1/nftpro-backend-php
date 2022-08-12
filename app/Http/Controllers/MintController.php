<?php

namespace App\Http\Controllers;

use App\Enums\TransactionType;
use App\Http\Requests\MintRequest;
use App\Jobs\CheckTransactionStatus;
use App\Models\Config;
use App\Models\Nft;
use App\Models\TokenId;
use App\Services\NftProMinter;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MintController extends Controller
{
    private NftProMinter $minter;

    public function __construct(NftProMinter $minter)
    {
        $this->minter = $minter;
    }

    public function create(MintRequest $request, $chain)
    {
        try {
            $amount = Config::query()->firstOrFail()->{$chain . '_mint_price'};
            $request->user()->subtractGems($amount);
        } catch (\Throwable $exception) {
            throw new BadRequestHttpException($exception->getMessage());
        }

        try {
            $data = $this->minter->mint(
                $chain,
                $request->wallet_address,
                $request->file('image'),
                $request->name,
                $request->description
            );
        } catch (\Throwable $exception) {
            $request->user()->addGems($amount);
            throw new BadRequestHttpException('Transaction fail');
        }

        $nft = Nft::query()->create([
            'name'             => $data['pinData']['name'],
            'blockchain'       => $chain,
            'description'      => $data['pinData']['description'],
            'image_url'        => $data['pinData']['image'],
            'token_id'         => TokenId::query()->whereBlockchain($chain)->firstOrFail()->latest_used,
            'contract_address' => $data['mintData']['to'],
            'owner_address'    => $request->wallet_address,
            'creator_address'  => $request->wallet_address,
            'transaction_hash' => $data['mintData']['hash'],
        ]);

        CheckTransactionStatus::dispatch($nft->transaction_hash, $nft->blockchain, TransactionType::mint())
                              ->delay(now()->addSeconds(10));
    }
}
