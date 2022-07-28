<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConfigResource;
use App\Models\Config;

class ConfigController extends Controller
{
    public function show()
    {
        $config = Config::first();

        return ConfigResource::make($config);
    }
}
