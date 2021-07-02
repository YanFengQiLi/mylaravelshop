<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MemberCoupon
 *
 * @property int $id
 * @property int $member_id 用户ID
 * @property int $coupon_code_id 优惠券ID
 * @property int $overdue 是否过期
 * @property string $over_time 过期时间
 * @property string $use_status 优惠券状态
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CouponCode $coupon
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberCoupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberCoupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberCoupon query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberCoupon whereCouponCodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberCoupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberCoupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberCoupon whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberCoupon whereOverTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberCoupon whereOverdue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberCoupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberCoupon whereUseStatus($value)
 * @mixin \Eloquent
 */
class MemberCoupon extends Model
{
    protected $table = 'member_coupon';

    protected $fillable = [
        'member_id',
        'coupon_code_id',
        'overdue',
        'over_time',
        'use_status'
    ];

    const RECEIVED = '1';
    const RECEIVE_USING = '2';
    const RECEIVE_USED = '3';

    public static $receive = [
        self::RECEIVED => '未使用',
        self::RECEIVE_USING => '使用中',
        self::RECEIVE_USED => '已使用'
    ];

    public function coupon() {
        return $this->belongsTo(CouponCode::class, 'coupon_code_id', 'id');
    }
}
