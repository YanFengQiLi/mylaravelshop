<?php

namespace App\Events;

use App\Models\MemberSubscribeProduct;
use Illuminate\Queue\SerializesModels;

class AttentionProductLowerPrice
{
    //  它将我们的事件类参数 ORM 优雅的序列化，传递给事件监听器，即监听器中 以 handle 开头的方法名或者 handle（）, 接受的参数 $event 就是经过序列化的 ORM 对象
    use SerializesModels;

    public $productSubscribe;

    /**
     * AttentionProductLowerPrice constructor.
     * @param MemberSubscribeProduct $memberSubscribeProduct
     * 事件类参数，接受的是一个 ORM 对象
     */
    public function __construct(MemberSubscribeProduct $memberSubscribeProduct)
    {
        $this->productSubscribe = $memberSubscribeProduct;
    }
}
