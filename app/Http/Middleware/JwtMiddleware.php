<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['error' => 'Token has expired'], 401);
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['error' => 'Invalid token'], 401);
            } else {
                return response()->json(['error' => 'Token Signature could not be verified'], 401);
            }
        }

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Pass the authenticated user to the request for later use
        $request->user = $user;

        return $next($request);
    }
}
