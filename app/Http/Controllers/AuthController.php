<?php

namespace App\Http\Controllers;

use DateTimeImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Lcobucci\JWT\JwtFacade;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Rsa\Sha256;

class AuthController extends Controller
{
    public function login()
    {

    }

    public function issueToken($user_id)
    {
        $key = InMemory::base64Encoded(
            substr(config('app.key'), 7)
        );

        $token = (new JwtFacade())->issue(
            new Sha256(),
            $key,
            static fn (
                Builder $builder,
                DateTimeImmutable $issuedAt
            ): Builder => $builder
                ->issuedBy(config('app.url'))
                ->permittedFor(config('app.url'))
                ->withClaim('uid', $user_id)
                ->expiresAt($issuedAt->modify('+60 minutes'))
        );

        return $token->toString();        
    }
}