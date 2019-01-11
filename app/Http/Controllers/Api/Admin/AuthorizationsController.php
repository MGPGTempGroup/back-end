<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\AuthticateRequest;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\UpdatePasswordRequest;
use Auth;
use Tymon\JWTAuth\JWTGuard;
use Illuminate\Support\Facades\Hash;

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
     * 修改密码接口
     */
    public function changePassword(UpdatePasswordRequest $request)
    {
        // 验证用户输入的旧密码是否正确
        $oldPwd = $request->input('old_pwd');
        if (! Hash::check($oldPwd, $this->user()->password)) {
            return $this->response->errorForbidden('Incorrect password');
        }

        // 修改密码
        $this->user()->password = Hash::make($request->input('new_pwd'));
        $this->user()->save();

        // 注销当前Token
        Auth::guard('api')->logout();

        return $this->response->created();
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
