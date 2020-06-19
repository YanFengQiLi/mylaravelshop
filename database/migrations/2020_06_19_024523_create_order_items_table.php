<?php
/**
 * @author zhenhong~
 * @description 订单明细表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('order_id')->comment('订单ID');
            $table->unsignedInteger('product_id')->comment('商品ID');
            $table->unsignedInteger('product_sku_id')->comment('商品skuID');
            $table->decimal('price',10,2)->comment('价格');
            $table->text('review')->nullable()->comment('商品评价');
            $table->dateTime('review_at')->nullable()->comment('商品评价时间');
            $table->unsignedInteger('rating')->nullable()->comment('商品评分');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
