<?php
/**
 * @author zhenhong~
 * @description 订单模型
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $member_id 用户ID
 * @property int|null $coupon_code_id 优惠券ID
 * @property string $order_no 订单编号
 * @property string $order_address 订单地址json
 * @property float $total_price 订单总金额
 * @property string $pay_method 支付方式
 * @property string $pay_no 三方订单号
 * @property string|null $remark 订单附加信息
 * @property string|null $refund_no 退款单号
 * @property string|null $paid_at 支付时间
 * @property int $closed 订单是否关闭
 * @property int $reviewed 订单是否评价
 * @property string|null $deliver_data 物流信息json
 * @property string|null $extra 物流附加信息
 * @property string $pay_status 支付状态
 * @property string $deliver_status 物流状态
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCouponCodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereDeliverData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereDeliverStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereOrderAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePayMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePayNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePayStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereRefundNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereReviewed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
