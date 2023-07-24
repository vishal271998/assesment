<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class JwtExceptionHandler extends ExceptionHandler
{
    public function render($request, Exception|\Throwable $exception)
    {
        if ($exception instanceof TokenExpiredException) {
            return response()->json(['error' => 'Token has expired'], 401);
        } elseif ($exception instanceof TokenInvalidException) {
            return response()->json(['error' => 'Invalid token'], 401);
        } elseif ($exception instanceof JWTException) {
            return response()->json(['error' => 'Could not decode token'], 401);
        } elseif ($exception instanceof HttpException && $exception->getStatusCode() === 403) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return parent::render($request, $exception);
    }
}
