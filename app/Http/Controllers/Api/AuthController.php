<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', [
            'except' => ['passwordLogin', 'mobileLogin', 'weiXinLogin', 'refresh']
        ]);
    }

    /**
     * 密码登录
     * @param Request $request
     * @param Member $member
     * @return \Illuminate\Http\JsonResponse
     */
    public function passwordLogin(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|alpha_dash|between:6,14',
        ],[
            'email.required' => '请填写邮箱',
            'email.email' => '邮箱格式错误',
            'password.required' => '请填写密码',
            'password.alpha_dash' => '密码只允许包含字母、数字，以及破折号 (-) 和下划线 ( _ )',
            'password.between' => '密码长度只能在6-14之间',
        ]);

        if (! $token = auth('api')->attempt($data)) {
            return api_response(201, [], '账号或密码错误');
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
     * @return \Illuminate\Http\JsonResponse
     * 退出登录
     * @author zhenhong~
     */
    public function logout()
    {
        auth('api')->logout();

        return api_response(200, [], '退出成功');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 获取当前用户
     * @author zhenhong~
     */
    public function me()
    {
        return api_response(200, auth('api')->user(), '获取成功');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 刷新token
     * @author zhenhong~
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     * 返回 token
     * @author zhenhong~
     */
    protected function respondWithToken($token)
    {
        return api_response(200, [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL()
        ], '获取成功');
    }
}
