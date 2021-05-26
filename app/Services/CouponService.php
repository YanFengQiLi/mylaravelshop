<?php
namespace App\Services;

use App\Models\CouponCode;

class CouponService
{
    protected $coupon;

    public function __construct(CouponCode $code)
    {
        $this->coupon = $code;
    }

    /**
     * @param $productService
     * @return CouponCode[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     * @author zhenhong~
     * 获取商品可以使用的优惠券
     */
    public function getCanUseCouponListByProduct($productService)
    {
        $categoryId = $productService->category_id;

        $list = $this->coupon::query()->where('enable', 1)->where('total', '>', 0)
            //  最外层 () 不能丢, 否则会失去优先级, 因为 AND 优先级最高
            ->whereRaw('((before_time IS NULL AND after_time IS NULL) OR (now() >= before_time AND after_time > now()))')
            ->where(function ($query) use ($categoryId) {
                $query->whereRaw("find_in_set($categoryId, use_type_id)")
                    ->orWhere('use_type', '=' , 'all');
            })
            ->get(['id', 'name', 'code', 'type', 'use_type', 'use_type_id', 'min_amount']);

        return $list;
    }
}
