<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetLoginMessageRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\LoginAttempt;
use App\Models\User;
use Elliptic\EC;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use kornrunner\Keccak;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class AuthController extends Controller
{
    public function message(GetLoginMessageRequest $request)
    {
        $nonce   = Str::random();
        $message = "Sign this message to confirm you own this wallet address. This action will not cost any gas fees.Nonce: " . $nonce;

        LoginAttempt::query()
                    ->updateOrCreate(
                        [
                            'wallet_address' => $request->wallet_address,
                        ],
                        [
                            'message' => $message,
                        ]
                    );

        return response()->json([
            'date' => [
                'message' => $message,
            ],
        ]);
    }

    public function login(LoginRequest $request)
    {
        $loginAttempt = LoginAttempt::query()->whereWalletAddress($request->wallet_address)->firstOrFail();
        $result       = $this->verifySignature($loginAttempt->message, $request->signature, $request->wallet_address);

        if (!$result) {
            throw new UnprocessableEntityHttpException('Invalid Signature');
        }

        $user = User::query()->firstOrCreate(
            [
                'wallet_address' => $request->wallet_address,
            ]);

        return UserResource::withToken($user);
    }

    protected function verifySignature(string $message, string $signature, string $address): bool
    {
        $hash  = Keccak::hash(sprintf("\x19Ethereum Signed Message:\n%s%s", strlen($message), $message), 256);
        $sign  = [
            'r' => substr($signature, 2, 64),
            's' => substr($signature, 66, 64),
        ];
        $recid = ord(hex2bin(substr($signature, 130, 2))) - 27;

        if ($recid != ($recid & 1)) {
            return false;
        }

        $pubkey          = (new EC('secp256k1'))->recoverPubKey($hash, $sign, $recid);
        $derived_address = '0x' . substr(Keccak::hash(substr(hex2bin($pubkey->encode('hex')), 1), 256), 24);

        return (Str::lower($address) === $derived_address);
    }
}
