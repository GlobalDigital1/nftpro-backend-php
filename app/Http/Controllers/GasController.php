<?php

namespace App\Http\Controllers;

use App\Services\Owlracle;

class GasController extends Controller
{
    private Owlracle $owlracle;

    public function __construct(Owlracle $owlracle) {
        $this->owlracle = $owlracle;
    }

    public function show($chain)
    {
        return $this->owlracle->{"get{$chain}Gas"}();
    }
}
