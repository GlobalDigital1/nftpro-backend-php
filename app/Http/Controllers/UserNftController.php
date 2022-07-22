<?php

namespace App\Http\Controllers;

use App\Http\Resources\NftResource;
use Illuminate\Http\Request;

class UserNftController extends Controller
{
    public function index(Request $request)
    {
        $nfts = $request->user()
                        ->nfts()
                        ->available()
                        ->orderByDesc('created_at')
                        ->paginate();

        return NftResource::collection($nfts);
    }

    public function show(Request $request, $id)
    {
        $nft = $request->user()
                       ->nfts()
                       ->available()
                       ->findOrFail($id);

        return NftResource::make($nft);
    }
}
