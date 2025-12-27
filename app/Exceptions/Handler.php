<?php

namespace App\Exceptions;

use Throwable;
use App\Helpers\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
class Handler extends ExceptionHandler
{
    /**
     * Handle JSON validation errors.
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        return ApiResponse::error(
            'Validation failed',
            $exception->errors(),
            422
        );
    }

    /**
     * Handle unauthenticated errors.
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return ApiResponse::error(
            'Unauthenticated',
            null,
            401
        );
    }
    protected function renderAuthorizationException($request, AuthorizationException $e)
    {
        return ApiResponse::error(
            'Forbidden',
            null,
            403
        );
    }
    public function render($request, Throwable $e)
    {
        if ($request->expectsJson() && $e instanceof NotFoundHttpException) {
            return ApiResponse::error('Resource not found', null, 404);
        }

        return parent::render($request, $e);
    }
}
