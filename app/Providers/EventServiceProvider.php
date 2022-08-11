<?php

namespace App\Providers;

use App\Events\TransactionCompleted;
use App\Events\TransactionFailed;
use App\Listeners\ApplyTransferToNft;
use App\Listeners\MarkMintedNftAsAvailable;
use App\Listeners\MarkNotTransferredNftAsAvailable;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        TransactionCompleted::class => [
            MarkMintedNftAsAvailable::class,
            ApplyTransferToNft::class
        ],
        TransactionFailed::class => [
            MarkNotTransferredNftAsAvailable::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
