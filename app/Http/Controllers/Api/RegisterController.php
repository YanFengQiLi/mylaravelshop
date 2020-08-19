<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

/**
 * 注册控制器
 * Class RegisterController
 * @package App\Http\Controllers\Api
 */
class RegisterController extends Controller
{

    /**
     * 发送邮箱验证码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendEmailCode(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => '请填写邮箱',
            'email.email' => '邮箱格式错误'
        ]);

        $code = generate_rand_number(6);

        Cache::store('redis')->put('email_' . $data['email'], $code, 10 * 60);

        $content = '感谢您对' . env('APP_NAME') . '的信任,我将做的更好, 您的验证码为 :' . $code . ' ,10分钟有效, 请勿告诉其他人';

        Mail::raw($content, function ($message) use ($data) {
            $title = '尊敬的用户,您好! 感谢您注册' . env('APP_NAME');

            $message->to($data['email'])->subject($title);
        });

        //  判断邮件是否发送成功
        if (count(Mail::failures()) > 0) {
            return api_response(201, [], '邮件发送失败,请重试');
        } else {
            return api_response(200, [], '邮件发送成功, 请注意查收');
        }
    }

    /**
     * 用户邮箱注册
     * @param RegisterRequest $registerRequest
     * @param Member $member
     * @return \Illuminate\Http\JsonResponse
     */
    public function memberEmailRegister(RegisterRequest $registerRequest, Member $member)
    {
        $date = $registerRequest->validated();

        $bool = $member->createMemberByData($date);

        if ($bool) {
            return api_response(200, [], '注册成功');
        } else {
            return api_response(201, [], '注册失败');
        }
    }
}
