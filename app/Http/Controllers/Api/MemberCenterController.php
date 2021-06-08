<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MemberService;
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

    /**
     * @param MemberService $service
     * @return \Illuminate\Http\JsonResponse
     * @author zhenhong~
     * 设置用户基本资料
     */
    public function setBaseMemberInfo(Request $request,MemberService $service)
    {
        $type = request('type');

        $value = request('value','');

        $arr = ['sex', 'birthday', 'nick_name', 'user_name'];

        if (!in_array($type, $arr)) {
            return api_response(201, [], '参数错误');
        }

        switch ($type) {
            case 'sex':
                if (!is_numeric($value) || !in_array($value, [0, 1])) return api_response(201, [],'性别错误');
                break;
            case 'birthday':
                if (check_date_valid($value) === false) return api_response(201, [], '日期格式错误');
                break;
            case 'nick_name':
                if (empty($value)) return api_response(201, [], '请填写昵称');
                break;
            case 'user_name':
                if (empty($value)) return api_response(201, [], '请填写姓名');
                break;
        }

        $user = auth()->user();

        $bool = $service->updateBaseMemberColumn(['id' => $user->id], $type, $value);

        if ($bool) {
            return api_response(200, $value, '设置成功');
        } else {
            return api_response(201, [], '设置失败');
        }
    }
}
