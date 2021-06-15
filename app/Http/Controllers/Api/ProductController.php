<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberCartRequest;
use App\Models\MemberCart;
use App\Models\ProductsService;
use App\Models\Website;
use App\Services\CouponService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
    /**
     * @param ProductService $productService
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author zhenhong~
     * 获取商品详情
     */
    public function getProductDetail
    (
        ProductService $productService,
        CouponService $couponService,
        Website $website,
        Request $request
    )
    {
        $id = $request->get('id');

        $info = $productService->findProductById($id);

        $coupons = $couponService->getCanUseCouponListByProduct($info);

        $memberCouponIds = Auth::check() ? $couponService->pluckAlreadyUsedMemberCouponIds(Auth::id(), 1, 2)->toArray() : [];

        if ($coupons) {
            $coupons->map(function ($item) use ($memberCouponIds) {
                $item->time_show = $item->is_limit_time ? Carbon::parse($item->before_time)->toDateString() . ' -- ' . Carbon::parse($item->after_time)->toDateString() : '无时间限制';

                //  is_collect-已领取 false-未领取
                if (empty($memberCouponIds)) {
                    $item->is_collect = false;
                } else {
                    $item->is_collect = in_array($item->id, $memberCouponIds) ? true : false;
                }

                return $item;
            });
        }

        $info->coupon_list = $coupons;

        $service = new ProductsService;

        $info->service_list = $service->getProductServiceByIds($info->service);

        $webSite = $website::getMoreWebSiteConfig('consume_integral_sign','consume_integral','consume_integral_percent');

        $planIntegral = $webSite['consume_integral'] == '0' ? $webSite['consume_integral']
            : round(($info->price * 100 ) * ($webSite['consume_integral_percent'] / 100) / 100);

        //  预计获得积分数量
        $info->plan_integral = $info->is_join_integral ? $planIntegral : 0;

        return api_response(200, $info, '获取成功');
    }

    /**
     * @param MemberCart $memberCart
     * @param MemberCartRequest $memberCartRequest
     * @return \Illuminate\Http\JsonResponse
     * @author zhenhong~
     * 添加商品到购物车
     */
    public function addCartProduct(
        MemberCart $memberCart,
        MemberCartRequest $memberCartRequest
    )
    {
        $data = $memberCartRequest->validated();

        $obj = $memberCart->createMemberCart($data + ['member_id' => Auth::id()]);

        if ($obj) {
            $info = $memberCart->getMemberCartInfo(['id' => $obj->id]);

            return api_response(200, [
                'id' => $info->id,
                'product_sku_id' => $info->product_sku_id,
                'product_id' => $info->productSku->product_id,
                'number' => $info->number,
                'title' => $info->productSku->title,
                'price' => $info->productSku->price,
                'img' => $info->productSku->img,
                'product_name' => $info->productSku->product->title
            ], '添加成功');
        } else {
            return api_response(201, [], '添加失败');
        }
    }

    /**
     * @param MemberCart $memberCart
     * @param MemberCartRequest $memberCartRequest
     * @return \Illuminate\Http\JsonResponse
     * @author zhenhong~
     * 修改购物车商品数量
     */
    public function updateCartProductNumber(
        MemberCart $memberCart,
        MemberCartRequest $memberCartRequest
    )
    {
        $member = auth()->user();

        $data = $memberCartRequest->validated();

        $type = request('type');

        if (!in_array($type, MemberCart::TYPE)) {
            return api_response(201, [], '无效操作');
        }

        switch ($type) {
            case 'add':
                $int = $memberCart->incMemberCartNumber([
                    'member_id' => $member->id,
                    'product_sku_id' => $data['product_sku_id']
                ], $data['number']);
                break;
            case 'sub':
                $int = $memberCart->decMemberCartNumber([
                    'member_id' => $member->id,
                    'product_sku_id' => $data['product_sku_id']
                ], 1);
                break;
        }

        if ($int > 0) {
            return api_response(200, [], '操作成功');
        } else {
            return api_response(201, [], '操作失败');
        }
    }
}
