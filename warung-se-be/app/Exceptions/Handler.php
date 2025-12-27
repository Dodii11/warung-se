<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Handle unauthenticated requests (API).
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json([
            'message' => 'Unauthenticated'
        ], 401);
    }

    /**
     * Register the exception handling callbacks.
     */
    public function register(): void
    {
        //
    }
}
