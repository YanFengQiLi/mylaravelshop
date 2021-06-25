<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MemberCart;
use App\Models\MemberCoupon;
use App\Models\MemberFavoriteProduct;
use App\Services\CouponService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    /**
     * @param Request $request
     * @param MemberCart $memberCart
     * @return \Illuminate\Http\JsonResponse
     * @author zhenhong~
     * 获取用户购物车列表
     */
    public function getMemberCartList(Request $request, MemberCart $memberCart)
    {
        $memberId = Auth::id();

        $perPage = $request->get('per_page', 10);

        $list = $memberCart->selectMemberCartList($memberId, $perPage);

        if ($list->total() > 0) {
            foreach ($list as $item) {
                $item->title = $item->productSku->title;
                $item->price = $item->productSku->price;
                $item->img = $item->productSku->img;
                $item->product_id = $item->productSku->product_id;
                $item->product_name = $item->productSku->product->product_name;

                unset($item->productSku);
            }
        }

        return api_response(200, ['list' => $list->items(), 'total' => $list->total(), 'last_page' => $list->lastPage()], '获取成功');
    }

    /**
     * @param Request $request
     * @param MemberFavoriteProduct $memberFavoriteProduct
     * @return \Illuminate\Http\JsonResponse
     * @author zhenhong~
     * 添加商品关注
     */
    public function createMemberFavoriteProduct(Request $request, MemberFavoriteProduct $memberFavoriteProduct)
    {
        $memberId = Auth::id();

        $productId = $request->post('product_id');

        if (empty($productId)) return api_response(201, [], '参数错误');

        $where = ['member_id' => $memberId, 'product_id' => $productId];

        $is = $memberFavoriteProduct->checkMemberFavoriteProductIsExist($where, true);

        if ($is) {
            $model = $memberFavoriteProduct->restoreMemberFavoriteProduct($where);
        } else {
            $model = $memberFavoriteProduct->insertMemberFavoriteProduct($where);
        }

        if ($model) {
            return api_response(200, [], '关注成功');
        } else {
            return api_response(201, [], '关注失败');
        }
    }

    /**
     * @param Request $request
     * @param MemberFavoriteProduct $memberFavoriteProduct
     * @return \Illuminate\Http\JsonResponse
     * @author zhenhong~
     * 取消商品关注
     */
    public function cancelMemberFavoriteProduct(Request $request, MemberFavoriteProduct $memberFavoriteProduct)
    {
        $ids = $request->post('product_id','');

        if (!is_string($ids) || empty($ids)) return api_response(201, [], '参数错误');

        $num = $memberFavoriteProduct->deleteMemberFavoriteProduct(Auth::id(), explode(',', $ids));

        if ($num > 0) {
            return api_response(200, [], '取关成功');
        } else {
            return api_response(201, [], '取关失败');
        }
    }

    /**
     * @param Request $request
     * @param MemberFavoriteProduct $memberFavoriteProduct
     * @return \Illuminate\Http\JsonResponse
     * @author zhenhong~
     * 获取用户关注的商品列表
     */
    public function getMemberFavoriteProductsList(Request $request, MemberFavoriteProduct $memberFavoriteProduct)
    {
        $memberId = Auth::id();

        $perPage = $request->get('per_page', 10);

        $list = $memberFavoriteProduct->selectMemberFavoriteProductList($memberId, $perPage);

        return api_response(200, ['list' => $list->items(), 'total' => $list->total(), 'last_page' => $list->lastPage()], '获取成功');
    }
}
