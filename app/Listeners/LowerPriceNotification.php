<?php

namespace App\Listeners;

use App\Events\ProductUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class LowerPriceNotification implements ShouldQueue
{
    protected $redis;

    protected $subscribe_key = 'subscribe_product_lower_';

    public function __construct()
    {
        $this->redis = Redis::connection('rds_queue');
    }

    /**
     * 处理事件监听器队列
     * @param ProductUpdated $event
     *
     * 总结：
     *      这个事件监听器队列其实就是生产者，那么有了生产者必定要有消费者去消费这个队列，
     *      所以必须在终端运行 `php artisan queue:work redis --queue=lower_price`, 其中 redis 是指使用 redis 作为队列驱动， --queue=lower_price 是指队列名称
     *      另外在一个项目中，不可能只存在一个队列，那么此时就需要指定多个消费者队列，即 --queue=队列1,队列2,队列3...
     *      而在生产环境下，因为我们在代码中已经定义好了各个队列生产者，那么就需要将消费者挂载到后台运行，这样一有队列的生产者，就会自动去消费这些队列
     *      即 `php artisan queue:work redis --queue=队列1，队列2... --daemon`
     */
    public function handle(ProductUpdated $event)
    {
        $key = $this->subscribe_key . $event->product->id;

        $members = $this->redis->sMembers($key);

        $time = time();

        $msg = [
            'title' => '商品降价通知',
            'message' => '您关注的'. $event->product->title . '商品, 已降价' . $event->product->lower_price . '元, 赶快去下单吧！',
            'time' => $time,
            'type' => config('notify_type.lower_price'),
            'relation' => [
                'product_id' => $event->product->id
            ]
        ];

        foreach ($members as $item) {
            $this->redis->zAdd('member_message_' . $item, $time, json_encode($msg, JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * 确定监听器是否应加入队列, 方法名必须为 shouldQueue
     * @param ProductUpdated $event
     * @return bool
     */
    public function shouldQueue(ProductUpdated $event)
    {
        $key = $this->subscribe_key . $event->product->id;

        $number = $this->redis->sCard($key);

        Log::channel('product_lower_price')->info('shouldQueue', [
            'number' => $number,
            'is_lower' => $event->product->is_lower
        ]);

        return $event->product->is_lower == 1 && $number > 0;
    }
}
