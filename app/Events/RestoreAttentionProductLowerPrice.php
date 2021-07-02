<?php

namespace App\Events;

use App\Models\MemberSubscribeProduct;
use Illuminate\Queue\SerializesModels;

class RestoreAttentionProductLowerPrice
{
    use SerializesModels;

    public $productSubscribe;

    /**
     * RestoreAttentionProductLowerPrice constructor.
     * @param MemberSubscribeProduct $memberSubscribeProduct
     */
    public function __construct(MemberSubscribeProduct $memberSubscribeProduct)
    {
        $this->productSubscribe = $memberSubscribeProduct;
    }
}
