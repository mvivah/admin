<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use Illuminate\Routing\Controller;

class BaseApiController extends Controller
{
    protected function success($data = null, $message = 'OK', $status = 200)
    {
        return ApiResponse::success($data, $message, $status);
    }

    protected function error($message = 'Error', $errors = null, $status = 400)
    {
        return ApiResponse::error($message, $errors, $status);
    }
}
