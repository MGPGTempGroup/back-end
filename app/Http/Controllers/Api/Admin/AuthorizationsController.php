<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\AuthticateRequest;
use App\Http\Controllers\Controller;

use Auth;

class AuthorizationsController extends Controller
{
    /**
     * Authenticate user login
     */
    public function authenticate(AuthticateRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (!$token = Auth::guard('admin')->attempt($credentials)) {
            return $this->response->errorUnauthorized('Email or password error');
        }

        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expire_at' => time() + Auth::guard('api')->factory()->getTTL() * 60
        ])->setStatusCode(201);
    }
}
