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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * 发送邮箱验证码
     * @author zhenhong~
     */
    public function sendEmailCode(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => '请填写邮箱',
            'email.email' => '邮箱格式错误'
        ]);

        $key = 'email_' . $data['email'];

        if (Cache::store('redis')->get($key)) {
            return api_response(200, [], '邮件发送成功, 请注意查收');
        }

        $code = generate_rand_number(6);

        Cache::store('redis')->put($key, $code, 10 * 60);

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
     * @param RegisterRequest $registerRequest
     * @param Member $member
     * @return \Illuminate\Http\JsonResponse
     * 用户邮箱注册
     * @author zhenhong~
     */
    public function memberEmailRegister(RegisterRequest $registerRequest, Member $member)
    {
        $data = $registerRequest->validated();

        $data['photo'] = 'http://image.yanfengqili.top/default_photo/head_photo.png';

        $bool = $member->createMemberByData($data);

        if ($bool) {
            return api_response(200, [], '注册成功');
        } else {
            return api_response(201, [], '注册失败');
        }
    }
}
