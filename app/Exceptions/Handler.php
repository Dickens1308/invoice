<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Response;
use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpFoundation\Response as Responses;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //

    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //

    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->renderable(function (TokenInvalidException $e, $request) {
            return Response::json(['status' => Responses::HTTP_UNAUTHORIZED, 'message' => 'Invalid access token'], 401);
        });
        $this->renderable(function (TokenExpiredException $e, $request) {
            return Response::json(['status' => Responses::HTTP_UNAUTHORIZED, 'message' => 'Token provided has Expired'], 401);
        });

        $this->renderable(function (JWTException $e, $request) {
            return Response::json(['status' => Responses::HTTP_UNAUTHORIZED, 'message' => 'Failed to parse token'], 401);
        });

        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
