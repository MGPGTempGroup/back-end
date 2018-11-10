<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\AuthticateRequest;
use App\Http\Controllers\Controller;

use Auth;

class AuthorizationsController extends Controller
{
    /**
     * 登录接口
     */
    public function authenticate(AuthticateRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return $this->response->errorUnauthorized('Email or password error');
        }

        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expire_at' => time() + Auth::guard('api')->factory()->getTTL() * 60
        ])->setStatusCode(201);
    }

    /**
     * 退出接口
     */
    public function logout()
    {
        Auth::guard('api')->logout();
        return $this->response->noContent();
    }
}
