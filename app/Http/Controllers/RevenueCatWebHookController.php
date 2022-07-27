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
        $user = User::query()->find(Arr::get($event, 'original_app_user_id'));
        $amount = 10;
        if (!$user) {
            return;
        }
        $user->addGems($amount);
    }
}
