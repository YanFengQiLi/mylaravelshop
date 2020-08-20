<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class AuthController extends Controller
{
    public function __construct()
    {
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
    public function passwordLogin(Request $request, Member $member)
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

        $result = $member->getMemberInfoByData(Arr::except($data, ['password']));

        if (! $result) {
            return api_response(201, [], '账号不存在');
        }

        if (! Hash::check($data['password'], $result->password)) {
            return api_response(201, [], '密码错误');
        }

        $payload = JWTFactory::customClaims(['sub' => $result])->make();

        $token = JWTAuth::encode($payload)->get();

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
        return api_response(200, $token, '获取成功');
    }
}
