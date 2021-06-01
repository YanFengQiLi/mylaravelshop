<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * 个人中心
 * Class MemberCenterController
 * @package App\Http\Controllers\Api
 */
class MemberCenterController extends Controller
{
    /**
     * 获取用户个人信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMemberInfo(Request $request)
    {
        $member = auth()->user();

        return api_response(200, $member, '获取成功');
    }
}
