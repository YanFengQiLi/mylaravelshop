<?php

namespace App\Observers;
/**
 * 订单观察者
 * Class OrderObserver
 * @package App\Observers
 */
class OrderObserver
{
    //  订单: 支付成功 / 申请退款 时, 向管理员推送后台消息
    public function saved()
    {

    }
}
