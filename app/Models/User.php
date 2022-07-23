<?php

namespace App\Models;

use App\Events\GemsAdded;
use App\Events\GemsSubtracted;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    protected $fillable = [
        'wallet_address',
        'name',
        'email',
        'email_notifications',
        'push_notifications',
    ];

    public function addGems($amount): void
    {
        event(new GemsAdded($this->id, $amount));
    }

    public function subtractGems($amount): void
    {
        event(new GemsSubtracted($this->id, $amount));
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
             ->singleFile();
    }

    public function nfts()
    {
        return $this->hasMany(Nft::class, 'owner_address', 'wallet_address');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('big')
             ->fit(Manipulations::FIT_CONTAIN, 1080, 1080)
             ->nonQueued();

        $this->addMediaConversion('medium')
             ->fit(Manipulations::FIT_CONTAIN, 540, 540)
             ->nonQueued();

        $this->addMediaConversion('small')
             ->fit(Manipulations::FIT_CONTAIN, 100, 100)
             ->nonQueued();
    }
}
