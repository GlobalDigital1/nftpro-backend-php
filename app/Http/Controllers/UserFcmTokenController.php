<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFcmTokenRequest;
use App\Models\FcmToken;

class UserFcmTokenController extends Controller
{
    public function create(CreateFcmTokenRequest $request)
    {
        FcmToken::query()->whereDeviceId($request->device_id)->delete();
        $request->user()->fcmTokens()->create($request->validated());
    }
}
