<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends BaseApiController
{
    public function user(Request $request)
    {
        return $this->success($request->user());
    }
    public function logout(Request $request)
    {
        $user = $request->user();
        // Revoke all tokens...
        $user->tokens()->delete();
        return $this->success(null, 'Logged out successfully');
    }
}
