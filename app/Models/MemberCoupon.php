<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MemberCoupon
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberCoupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberCoupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberCoupon query()
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
