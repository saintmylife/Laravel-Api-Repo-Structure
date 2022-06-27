<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

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
        $this->renderable(function (MethodNotAllowedHttpException $e) {
            return response()->json([
                'messages'  => $e->getMessage()
            ], 405);
        });
        $this->renderable(function (\Spatie\Permission\Exceptions\UnauthorizedException $e) {
            return response()->json([
                'messages'  => $e->getMessage()
            ], 401);
        });
        $this->renderable(function (\Illuminate\Http\Exceptions\ThrottleRequestsException $e) {
            return response()->json([
                'messages' => 'Too many request, please try again in ' . Carbon::now()->addSeconds($e->getHeaders()['Retry-After'])->diffForHumans()
            ], 429);
        });
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
