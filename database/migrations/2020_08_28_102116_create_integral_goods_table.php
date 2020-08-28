<?php
/**
 * @author zhenhong~
 * @descritpion 积分商品表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntegralGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('integral_goods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('商品名称');
            $table->decimal('price')->comment('商品价格');
            $table->unsignedInteger('on_sale')->default(0)->comment('上架状态');
            $table->string('thumb')->nullable()->comment('商品封面图');
            $table->text('pictures')->nullable()->comment('商品轮播图');
            $table->text('description')->comment('商品详情');
            $table->unsignedTinyInteger('type')->default(0)->comment('兑换类型');
            $table->decimal('money')->default(0.00)->comment('兑换金额');
            $table->unsignedInteger('number')->comment('兑换积分');
            $table->unsignedInteger('stock')->comment('库存');
            $table->unsignedTinyInteger('is_limit')->comment('兑换限制');
            $table->unsignedInteger('limit_number')->default(0)->comment('限制数量');
            $table->unsignedInteger('exchange_number')->default(0)->comment('已兑换数量');
            $table->unsignedInteger('sort')->default(1)->comment('排序');
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
        Schema::dropIfExists('integral_goods');
    }
}
