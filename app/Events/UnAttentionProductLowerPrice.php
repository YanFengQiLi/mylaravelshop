<?php

namespace App\Events;

use App\Models\MemberSubscribeProduct;
use Illuminate\Queue\SerializesModels;

class UnAttentionProductLowerPrice
{
    use SerializesModels;

    public $productSubscribe;

    /**
     * UnAttentionProductLowerPrice constructor.
     * @param MemberSubscribeProduct $memberSubscribeProduct
     */
    public function __construct(MemberSubscribeProduct $memberSubscribeProduct)
    {
        $this->productSubscribe = $memberSubscribeProduct;
    }

}
