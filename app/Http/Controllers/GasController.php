<?php

namespace App\Http\Controllers;

use App\Services\Owlracle;
use Illuminate\Support\Facades\Cache;

class GasController extends Controller
{
    private Owlracle $owlracle;

    public function __construct(Owlracle $owlracle) {
        $this->owlracle = $owlracle;
    }

    public function show($chain)
    {
        return Cache::remember("gas.$chain", 60, function () use ($chain) {
            return $this->owlracle->{"get{$chain}Gas"}();
        });


    }
}
