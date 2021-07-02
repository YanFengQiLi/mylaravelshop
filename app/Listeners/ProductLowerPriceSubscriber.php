<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Redis;

/**
 * Class ProductLowerPriceSubscriber
 * @package App\Listeners
 * @author zhenhong~
 * 事件订阅者
 * 个人理解：
 *      所谓事件订阅者,就是在自身内部将多个事件,统一的交给 `subscribe`(此方法名必须这么写) 去订阅, 将多个事件分别交给本类中对应的事件处理程序
 *
 *  我的思路：
 *  事件订阅者类，通过监听器将事件分发给了对应的事件处理程序，我在对应的事件处理程序中，
 *  操作 redis 数据库，将订阅用户存到了，subscribe_product_lower_商品ID 这个key中，
 *  当 ProductUpdated 事件监听到商品降价时，将我们储存起来的这些 用户ID 集合投放到 redis 队列中去通知用户商品降价
 */
class ProductLowerPriceSubscriber
{
    protected $redis;

    protected $subscribe_key = 'subscribe_product_lower_';

    public function __construct()
    {
        $this->redis = Redis::connection('rds_queue');
    }

    /**
     * @param $event
     * 处理降价通知订阅
     */
    public function handleLowerPriceSubscribe($event)
    {
        $subscribe = $event->productSubscribe;

        $key = $this->subscribe_key . $subscribe->product_id;

        $this->redis->sAdd($key, $subscribe->member_id);
    }

    /**
     * @param $event
     * 处理取消降价通知订阅
     */
    public function handleLowerPriceUnSubscribe($event)
    {
        $subscribe = $event->productSubscribe;

        $key = $this->subscribe_key . $subscribe->product_id;

        $this->redis->sRem($key, $subscribe->member_id);
    }

    /**
     * @param $event
     * 处理回关降价通知
     */
    public function handleLowerPriceAgainSubscribe($event)
    {
        $subscribe = $event->productSubscribe;

        $key = $this->subscribe_key . $subscribe->product_id;

        $this->redis->sAdd($key, $subscribe->member_id);
    }

    /**
     * 为订阅者注册监听器
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\AttentionProductLowerPrice',
            'App\Listeners\ProductLowerPriceSubscriber@handleLowerPriceSubscribe'
        );

        $events->listen(
            'App\Events\UnAttentionProductLowerPrice',
            'App\Listeners\ProductLowerPriceSubscriber@handleLowerPriceUnSubscribe'
        );

        $events->listen(
            'App\Events\RestoreAttentionProductLowerPrice',
            'App\Listeners\ProductLowerPriceSubscriber@handleLowerPriceAgainSubscribe'
        );
    }
}
