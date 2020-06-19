<?php
/**
 * @author zhenhong~
 * @description 用户优惠券模型
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberCoupon extends Model
{
    protected $table = 'member_coupons';

    const WAIT_RECEIVE = '1';
    const RECEIVED = '2';
    const RECEIVE_USING = '3';
    const RECEIVE_USED = '4';

    public static $receive = [
        self::WAIT_RECEIVE => '未领取',
        self::RECEIVED => '未使用',
        self::RECEIVE_USING => '使用中',
        self::RECEIVE_USED => '已使用'
    ];
}
