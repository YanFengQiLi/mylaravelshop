<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductsService;
use App\Models\Website;
use App\Services\CouponService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


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

        if ($coupons) {
            $coupons->map(function ($item) {
                $item->time_show = $item->is_limit_time ? Carbon::parse($item->before_time)->toDateString() . ' -- ' . Carbon::parse($item->after_time)->toDateString() : '无时间限制';

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
}
