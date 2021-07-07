<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        /**
         *  我这里的降价通知思路整理：
         *  将订阅了降价通知的用户，放入队列，
         *      1. 创建降价通知的 3个 自定义事件
         *      2. 首先在 memberSubscribeProduct 模型上, 将 `created` 、 `deleted` 、 `restored` 三个生命周期节点, 分发到我们自定义的事件中
         *      3. 创建事件订阅者, 将对应的事件统一交给 subscribe 方法去分发
         *      4. 编写对应的事件处理程序
         *      5. 将事件订阅者类，添加到 EventServiceProvider 的 $subscribe 数组中
         */
        //  注册事件和监听器，定义好事件和事件监听器的路径，直接使用 `php artisan make:generate`，就会生成该事件和事件的全部监听器
        'App\Events\ProductUpdated' => [
            //  设置降价标识
            'App\Listeners\ChangeProductLowerColumn',
            //  降价价通知
            'App\Listeners\LowerPriceNotification',
        ],
    ];

    //  注册订阅者
    protected $subscribe = [
        'App\Listeners\ProductLowerPriceSubscriber'
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
