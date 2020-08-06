<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

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
