<?php

namespace App\Exceptions;

use ErrorException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (QueryException $e, $request) {
            if ($e->getCode() == '42S22') {
                $errorMessage = $e->getMessage();
                return response()->view('errors.db_error', ['error' => $errorMessage], 500);
            }

            if ($e->getCode() == '23000') {
                $errorMessage = $e->getMessage();
                return response()->view('errors.db_error', ['error' => $errorMessage], 500);
            }

            if ($e->getCode() == '22001') {
                $errorMessage = $e->getMessage();
                return response()->view('errors.db_error', ['error' => $errorMessage], 500);
            }

            if ($e->getCode() == 'HY000') {
                $errorMessage = $e->getMessage();
                return response()->view('errors.db_error', ['error' => $errorMessage], 500);
            }

            // Si el error tiene la cadena Attemp to read property
            if ($e instanceof ErrorException && strpos($e->getMessage(), "Attempt to read property") != false) {
                $errorMessage = $e->getMessage();
                return response()->view('errors.db_error', ['error' => $errorMessage], 500);
            }
        });
    }
}
