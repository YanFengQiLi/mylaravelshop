<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GroupOrder
 *
 * @property int $id
 * @property string $order_no 订单编号
 * @property int $member_id 用户ID
 * @property string $address 订单地址json
 * @property int $buy_number 购买数量
 * @property float $total_price 订单总金额
 * @property string $pay_method 支付方式
 * @property string $pay_no 三方订单号
 * @property string|null $remark 订单附加信息
 * @property string|null $refund_no 退款单号
 * @property int $closed 订单是否关闭
 * @property int $is_reviewed 订单是否评价
 * @property string|null $deliver_data 物流信息json
 * @property string|null $extra 物流附加信息
 * @property string $pay_status 支付状态
 * @property string $deliver_status 物流状态
 * @property string|null $paid_at 支付时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupOrder whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupOrder whereBuyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupOrder whereClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupOrder whereDeliverData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupOrder whereDeliverStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupOrder whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupOrder whereIsReviewed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupOrder whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupOrder whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupOrder wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupOrder wherePayMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupOrder wherePayNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupOrder wherePayStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupOrder whereRefundNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupOrder whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupOrder whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupOrder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GroupOrder extends Model
{
	
    protected $table = 'group_order';
    
}
