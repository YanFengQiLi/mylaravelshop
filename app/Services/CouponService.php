<?php
namespace App\Services;

use App\Models\CouponCode;
use App\Models\MemberCoupon;

class CouponService
{
    protected $coupon;

    protected $memberCoupon;

    public function __construct(
        CouponCode $code,
        MemberCoupon $memberCoupon
    )
    {
        $this->coupon = $code;
        $this->memberCoupon = $memberCoupon;
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
            ->whereRaw('((is_limit_time = 0) OR (now() >= before_time AND after_time > now()))')
            ->where(function ($query) use ($categoryId) {
                $query->whereRaw("find_in_set($categoryId, use_type_id)")
                    ->orWhere('use_type', '=' , 'all');
            })
            ->get(['id', 'name', 'code', 'type', 'value', 'use_type', 'is_limit_time', 'use_type_id', 'min_amount', 'before_time', 'after_time']);

        return $list;
    }

    /**
     * @param array $data
     * @return MemberCoupon|\Illuminate\Database\Eloquent\Model
     * @author zhenhong~
     * 创建用户优惠券
     */
    public function createMemberCoupon(array $data)
    {
        return $this->memberCoupon::create($data);
    }

    /**
     * @param $memberId
     * @param $type
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @author zhenhong~
     * 获取用户优惠券列表（个人中心）
     */
    public function getMemberCouponListByMemberId($memberId, $type, $limit = 10)
    {
        $list = $this->memberCoupon::query()
            ->with('coupon:id,type,name,value,use_type,is_limit_time,use_type_id,min_amount,before_time,after_time')
            ->where('use_status', $type)
            ->where('member_id', $memberId)
            ->paginate($limit);

        return $list;
    }

    /**
     * @param $id
     * @return CouponCode|CouponCode[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     * @author zhenhong~
     * 根据ID获取优惠券
     */
    public function findCouponById($id)
    {
       return $this->coupon::query()->where('enable', 1)->find($id);
    }

    /**
     * @param $couponId
     * @return int
     * @author zhenhong~
     * 减优惠券总量
     */
    public function decrementCouponTotalNumber($couponId)
    {
        return $this->coupon::query()->where('id', $couponId)->decrement('total', 1);
    }

    /**
     * @param $couponId
     * @return int
     * @author zhenhong~
     * 增加优惠券使用量
     */
    public function IncrementCouponUseNumber($couponId)
    {
        return $this->coupon::query()->where('id', $couponId)->increment('used', 1);
    }

    /**
     * @param $memberId
     * @param $status
     * @return \Illuminate\Support\Collection
     * @author zhenhong~
     * 获取用户已经使用的优惠券Ids
     * (逻辑：对于已经用A券成功付款，再次进入商品详情页领A券是允许的，而对于领券后未使用/使用A券结算商品生成订单未付款的商品，都是不能再次领券的)
     */
    public function pluckAlreadyUsedMemberCouponIds($memberId, ...$status)
    {
        return $this->memberCoupon::query()->where('overdue', 0)
            ->where('member_id', $memberId)
            ->whereIn('use_status', $status)->pluck('coupon_code_id');
    }
}
