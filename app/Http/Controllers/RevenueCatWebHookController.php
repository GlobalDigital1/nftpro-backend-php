<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class RevenueCatWebHookController extends Controller
{
    public function handle(Request $request)
    {
        $event = $request->get('event');
        Log::debug($event);
        if (Arr::get($event, 'type') !== 'NON_RENEWING_PURCHASE') {
            return;
        }
        $user   = User::query()->find(Arr::get($event, 'app_user_id'));
        if (!$user) {
            return;
        }

        $amount = (integer) str_replace('com.nftpro.', '', Arr::get($event, 'product_id'));
        $user->addGems($amount);
    }
}
