<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Throwable;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
     public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthenticationException) {
            // Check if the request expects a JSON response
            if ($request->is('api/*')) {
                return response()->json(['error' => 'Token is expired or invalid. Please login again.'], 401);
            }

            // For web requests, redirect to login page
            return redirect()->guest(route('login'))->with('error', 'Please login to continue.');
        }

        return parent::render($request, $exception);
    }
}
