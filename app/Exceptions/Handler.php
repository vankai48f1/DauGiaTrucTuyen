<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Str;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{

    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }


    public function render($request, Throwable $exception)
    {
        if ($request->isJson() || $request->is('api/*')) {
            if ($exception instanceof TokenMismatchException) {
                return response()->json([
                    RESPONSE_MESSAGE_KEY => __('Session expired due to inactivity. Please reload page'),
                ], 400);

            } elseif ($exception instanceof UnauthorizedException) {
                return response()->json([
                    RESPONSE_MESSAGE_KEY => Str::title(str_replace('_', ' ', $exception->getMessage()))
                ], $exception->getCode() ?: 401);
            } elseif ($exception instanceof ValidationException) {
                return response()->json($exception->errors(), $exception->getCode() ?: 422);
            } elseif ($exception instanceof AuthenticationException) {
                return response()->json([
                    RESPONSE_MESSAGE_KEY => "An authentication exception occurred."
                ], $exception->getCode() ?: 401);
            } else if (env('APP_ENV') === 'production') {
                return response()->json([
                    RESPONSE_MESSAGE_KEY => $exception->getMessage() ?: "Not Found!"
                ], $exception->getCode() ?: 404);
            }
        } else {
            if ($exception instanceof TokenMismatchException) {
                return redirect()->back()->with([RESPONSE_TYPE_ERROR => __('Session expired due to inactivity. Please try again')]);
            } elseif ($exception instanceof UnauthorizedException) {
                return response()->view('errors.' . $exception->getMessage(), [], $exception->getCode() ?: 401);
            } elseif (env('APP_ENV') == 'production' &&
                !$exception instanceof ValidationException &&
                !$exception instanceof AuthenticationException
            ) {
                return response()->view('errors.404');
            }
        }


        return parent::render($request, $exception);
    }
}
