<?php
/**
 * @author zhenhong~
 * @description 订单模型
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const WAIT_PAYING = '1';
    const PAID = '2';
    const APPLY_REFUND = '3';
    const REFUND_FAILED = '4';
    const REFUND_SUCCESS = '5';
    const APPLY_DELIVER = '6';
    const APPLY_DELIVER_FAILED = '7';
    const APPLY_DELIVER_SUCCESS = '8';

    const WAIT_DELIVER = '1';
    const DELIVERED = '2';
    const CONFIRMED_DELIVER = '3';


    public static $pay = [
        self::WAIT_PAYING => '待支付',
        self::PAID => '已付款',
        self::APPLY_REFUND => '申请退款中',
        self::REFUND_FAILED => '退款失败',
        self::REFUND_SUCCESS => '退款成功',
        self::APPLY_DELIVER => '申请换货中',
        self::APPLY_DELIVER_FAILED => '换货失败',
        self::APPLY_DELIVER_SUCCESS => '换货成功'
    ];

    public static $deliver = [
        self::WAIT_DELIVER => '待发货',
        self::DELIVERED => '已发货',
        self::CONFIRMED_DELIVER => '已收货'
    ];

    protected $table = 'orders';
}
