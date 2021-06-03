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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 获取用户个人中心
     * @author zhenhong~
     */
    public function getMemberInfo(Request $request)
    {
        $member = auth()->user();

        //  TODO 关注商品数量
        $member->attention_product_num = 0;

        //  TODO 广场收藏数量
        $member->square_like_num = 0;

        //  TODO 浏览商品数量
        $member->product_look_num = 0;

        //  TODO 优惠券 数量
        $member->coupon_num = 0;

        //  TODO 待付款 待发货 待收货 待评价 退换 数量
        $member->wait_paying_num = 0;

        $member->wait_deliver_num = 0;

        $member->delivered_num = 0;

        $member->reviewed_num = 0;

        $member->back_change_num = 0;

        //  TODO 获取超级会员天数，计划存 redis
        $member->super_day = 0;

        return api_response(200, $member, '获取成功');
    }
}
