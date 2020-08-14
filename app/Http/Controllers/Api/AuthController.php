<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', [
            'except' => ['passwordLogin', 'mobileLogin']
        ]);
    }

    /**
     * 邮箱密码登录
     * @return \Illuminate\Http\JsonResponse
     */
    public function passwordLogin()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return api_response(202, [], 'token错误');
        }

        return $this->respondWithToken($token);
    }

    //  TODO 准备接入阿里云短信
    public function mobileLogin()
    {

    }

    //  TODO 微信登录
    public function weiXinLogin()
    {

    }

    /**
     * 返回token
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithToken($token)
    {
        return api_response(200, [
            'access_token' => $token,
            'token_type' => 'bearer',
            //  默认是 60分钟, 这里设置为一周
            'expires_in' => auth('api')->factory()->getTTL() * 60 * 7
        ]);
    }
}
