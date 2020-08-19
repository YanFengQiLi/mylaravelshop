<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;

/**
 * 邮箱注册请求
 * Class RegisterRequest
 * @package App\Http\Requests
 */
class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:members,email',
            'code' => 'required',
            'password' => 'required|alpha_dash|between:6,14',
            'agree' => 'accepted'
        ];
    }

    public function messages()
    {
       return [
           'email.required' => '请填写邮箱',
           'email.email' => '邮箱格式错误',
           'email.unique' => '该邮箱已被注册',
           'code.required' => '请输入验证码',
           'password.required' => '请填写密码',
           'password.alpha_dash' => '密码只允许包含字母、数字，以及破折号 (-) 和下划线 ( _ )',
           'password.between' => '密码长度只能在6-14之间',
           'agree.accepted' => '请同意用户协议'
       ];
    }

    public function checkCode()
    {
        $data = $this->validationData();

        $code = Cache::get('email_'.$data['email']);

        return $code && $code == $data['code'] ? true : false;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator){
            $bool = $this->checkCode();

            if ($bool !== true) {
                $validator->errors()->add('code', '验证码错误');
            }
        });
    }
}
