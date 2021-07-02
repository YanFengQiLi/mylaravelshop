<?php

namespace App\Listeners;

use App\Events\ProductUpdated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChangeProductLowerColumn
{
    /**
     * Handle the event.
     *
     * @param  ProductUpdated  $event
     * @return void
     * 变更商品降价信息和标识
     */
    public function handle(ProductUpdated $event)
    {
        $product = $event->product;

        $oldPrice = ($product->getOriginal('price')) * 100;

        $newPrice = ($product->price) * 100;

        if ($newPrice < $oldPrice) {
            DB::table('products')->where('id', $product->id)->update([
                'lower_price' => number_format(($oldPrice - $newPrice) / 100, 2),
                'is_lower'    =>  1
            ]);
        } else {
            DB::table('products')->where('id', $product->id)->update([
                'lower_price' =>  0,
                'is_lower'    =>  0
            ]);
        }

        //  记录商品变更信息
        if ($newPrice != $oldPrice) {
            Log::channel('product_lower_price')->info('product_updated_info', [
                'id' => $product->id,
                'new_price' => number_format($newPrice / 100, 2),
                'old_price' => number_format($oldPrice / 100, 2),
                'date_time'  => now()->toDateTimeString()
            ]);
        }
    }
}
