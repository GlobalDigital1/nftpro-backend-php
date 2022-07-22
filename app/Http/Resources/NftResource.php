<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Nft */
class NftResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'               => $this->id,
            'name'             => $this->name,
            'description'      => $this->description,
            'image_url'        => $this->image_url,
            'contract_address' => $this->contract_address,
            'token_id'         => $this->token_id,
            'transaction_hash' => $this->transaction_hash,
            'is_available'     => $this->is_available,
            'created_at'       => $this->created_at,

            'owner_address'   => $this->owner_address,
            'creator_address' => $this->creator_address,
        ];
    }
}
