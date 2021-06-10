<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MemberCoupon;
use App\Services\CouponService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 会员控制器
 * Class MemberController
 * @package App\Http\Controllers\Api
 */
class MemberController extends Controller
{
    /**
     * @param Request $request
     * @param CouponService $service
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @author zhenhong~
     * 用户领取优惠券
     */
    public function getCoupon(Request $request, CouponService $service)
    {
        $couponId = $request->post('coupon_id');

        if (empty($couponId)) {
            return api_response(201, [], '无此优惠券');
        }

        $coupon = $service->findCouponById($couponId);
        if (! $coupon) {
            return api_response(201, [], '无此优惠券');
        }

        $member = auth()->user();

        //  此处我的设计想法是，虽然不限制使用时间，但是从当前领取日期开始人为+1年，如果还不使用，说明此用户无购物想法
        $time = strtotime('+1 year', strtotime(date('Y-m-d 00:00:00')));

        DB::beginTransaction();

        try {
            $service->createMemberCoupon([
                'member_id' => $member->id,
                'coupon_code_id' => $coupon->id,
                'overdue' => 0,
                'over_time' => $coupon->is_limit_time == 1 ? $coupon->after_time : date('Y-m-d 00:00:00', $time),
                'use_status' => MemberCoupon::RECEIVED
            ]);

            $service->decrementCouponTotalNumber($coupon->id);

            DB::commit();

            return api_response(200, [], '领取成功');
        } catch (\Exception $exception) {
            DB::rollBack();

            return api_response(201, [], $exception->getMessage());
        }
    }
}
