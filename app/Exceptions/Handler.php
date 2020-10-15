<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
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
        //
    }

    public function render($request, Throwable $e)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $code = $this->getExceptionHTTPStatusCode($e);
            return response()->json(
                $this->getJsonMessage($e, $code),
                $code
            );
        }

        return parent::render($request, $e);
    }

    protected function getExceptionHTTPStatusCode(Throwable $e)
    {
        if ($e instanceof HttpResponseException) {
            return $e->getCode();
        } elseif ($e instanceof AuthenticationException) {
            return 401;
        } elseif ($e instanceof ValidationException) {
            return $e->status;
        }
        return 500;
    }

    protected function getJsonMessage(Throwable $e, int $code)
    {
        return [
            'code' => $code,
            'data' => [],
            'message' => $e->getMessage()
        ];
    }
}
