<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SignService;
use Illuminate\Http\Request;

class SignController extends Controller
{
    protected $sign;

    public function __construct(SignService $service)
    {
        $this->sign = $service;
    }

    public function getMemberSignList(Request $request)
    {

    }

    /**
     * 用户签到
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function createSignRecord()
    {
        $bool = $this->sign->checkTodaySign();

        if ($bool === false) {
            return api_response(200, [], '今天已经签过到了,明天在来吧');
        }

        $result = $this->sign->sign();

        if ($result) {
            return api_response(200, [], '签到成功');
        } else {
            return api_response(201, [], '签到失败');
        }
    }
}
