<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\IntegralGoodsOrder
 *
 * @property int $id
 * @property string $order_no 订单编号
 * @property int $member_id 用户ID
 * @property int $number 兑换数量
 * @property int $integral_number 使用积分数量
 * @property float $money 使用金钱
 * @property string $order_address 订单地址json
 * @property string|null $deliver_data 物流信息json
 * @property string $pay_method 支付方式
 * @property string|null $remark 订单附加信息
 * @property string|null $refund_no 退款单号
 * @property string|null $pay_no 三方订单号
 * @property string|null $paid_at 支付时间
 * @property string $pay_status 支付状态
 * @property string $deliver_status 物流状态
 * @property int $reviewed 订单是否评价
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGoodsOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGoodsOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGoodsOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGoodsOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGoodsOrder whereDeliverData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGoodsOrder whereDeliverStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGoodsOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGoodsOrder whereIntegralNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGoodsOrder whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGoodsOrder whereMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGoodsOrder whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGoodsOrder whereOrderAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGoodsOrder whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGoodsOrder wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGoodsOrder wherePayMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGoodsOrder wherePayNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGoodsOrder wherePayStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGoodsOrder whereRefundNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGoodsOrder whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGoodsOrder whereReviewed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IntegralGoodsOrder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class IntegralGoodsOrder extends Model
{
	
    protected $table = 'integral_goods_order';
    
}
