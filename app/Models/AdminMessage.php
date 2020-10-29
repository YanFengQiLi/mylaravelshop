<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdminMessage
 *
 * @property int $id
 * @property int $type 消息类型
 * @property string $title 消息名称
 * @property string $extra 存储扩展信息
 * @property int $status 状态
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMessage whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMessage whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMessage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMessage whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMessage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AdminMessage extends Model
{

    protected $table = 'admin_messages';

    protected $fillable = [
        'type',
        'title',
        'extra',
        'status'
    ];

    //  已付款
    const ORDER_PAID = 1;
    //  退款申请
    const ORDER_REFUND = 2;
    //  消息类型
    const TYPE = [
        self::ORDER_PAID => '已付款通知',
        self::ORDER_REFUND => '退款申请通知'
    ];


}
