<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [

    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [

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
        $this->reportable(function (Throwable $e) {
        });

        $this->renderable(function (Throwable $e, Request $request) {
            if ($request->is('api/*') && !$e instanceof ValidationException) {
                $code = (int) $e->getCode();

                if(method_exists($e, 'getStatusCode')
                    && is_numeric($e->getStatusCode())
                ){
                    $code = (int) $e->getStatusCode();
                }

                if($e instanceof \Illuminate\Auth\AuthenticationException){
                    $code = 401;
                }

                return response()->json(
                    [
                        'message' => $e->getMessage(),
                        'code' => $code ?: 500,
                        'exception' => get_class($e),
                    ],
                    ($code >= 400 && $code < 500)
                        ? $code
                        : 500
                );
            }
        });
    }
}
