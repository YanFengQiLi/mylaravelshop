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
        //  auth:api 的 auth 就是 app\Http\Kernel.php $routeMiddleware 数组中的 auth 中间件, `:api` 就是 config\auth.php 的 guards 数组中的 api 看守器
        $this->middleware('jwt', [
            'except' => ['passwordLogin', 'mobileLogin', 'weiXinLogin']
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

        if (! $token = JWTAuth::attempt($data)) {
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
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     * 返回 token
     * @author zhenhong~
     */
    protected function respondWithToken($token)
    {
        return api_response(200, 'Bearer '.$token, '获取成功');
    }
}
