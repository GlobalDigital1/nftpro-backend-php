<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \Spatie\MediaLibrary\MediaCollections\Models\Media */
class MediaResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'original' => $this->getFullUrl(),
            'big'      => $this->getFullUrl('big'),
            'medium'   => $this->getFullUrl('medium'),
            'small'    => $this->getFullUrl('small'),
        ];
    }
}
