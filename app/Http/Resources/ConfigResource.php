<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Config */
class ConfigResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'ios_min_version'    => $this->ios_min_version,
            'eth_mint_price'     => $this->eth_mint_price,
            'polygon_mint_price' => $this->polygon_mint_price,
        ];
    }
}
