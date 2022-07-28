<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\User
 */
class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                  => $this->id,
            'wallet_id'           => $this->wallet_address,
            'name'                => $this->name,
            'email'               => $this->email,
            'email_notifications' => $this->when($request->user()?->id === $this->id, $this->email_notifications),
            'push_notifications'  => $this->when($request->user()?->id === $this->id, $this->push_notifications),
            'balance'             => $this->when($request->user()?->id === $this->id, $this->balance),
            'avatar'              => MediaResource::make($this->getFirstMedia('avatar')),
        ];
    }

    public static function withToken(User $user)
    {
        return static::make($user)->additional([
            'token' => $user->createToken('auth')->plainTextToken,
        ]);
    }
}
