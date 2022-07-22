<?php

namespace App\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class GemsAdded extends ShouldBeStored
{
    public int $user_id;
    public int $amount;

    public function __construct(int $user_id, int $amount)
    {
        $this->user_id = $user_id;
        $this->amount = $amount;
    }
}
