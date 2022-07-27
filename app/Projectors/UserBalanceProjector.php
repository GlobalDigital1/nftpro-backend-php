<?php

namespace App\Projectors;

use App\Events\GemsAdded;
use App\Events\GemsSubtracted;
use App\Models\User;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class UserBalanceProjector extends Projector
{
    public function onGemsAdded(GemsAdded $event)
    {
        $user = User::query()->findOrFail($event->user_id);

        $user->balance += $event->amount;

        $user->save();
    }

    public function onGemsSubtracted(GemsSubtracted $event)
    {
        $user = User::query()->findOrFail($event->user_id);

        $user->balance -= $event->amount;

        $user->save();
    }
}
