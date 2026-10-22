<?php

namespace App\Http\Parsers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\Http\Parser as ParserContract;

/**
 * Reads the JWT from "Authorization: Token <jwt>", the scheme required by the RealWorld api spec.
 */
class TokenAuthHeader implements ParserContract
{
    /**
     * Try to parse the token from the request header.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return null|string
     */
    public function parse(Request $request)
    {
        if (preg_match('/^Token\s+(\S+)$/i', (string) $request->headers->get('Authorization'), $matches)) {
            return $matches[1];
        }

        return null;
    }
}
