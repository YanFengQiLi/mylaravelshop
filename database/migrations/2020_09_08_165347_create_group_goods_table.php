<?php
/**
 * @author zhenhong~
 * 拼团商品表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupGoodsTable extends Migration
{
    /**
     * Run the migrations.
     * 注: 此表不设置开始时间,由上下架控制即可
     * @return void
     */
    public function up()
    {
        Schema::create('group_goods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->comment('商品标题');
            $table->string('thumb')->nullable()->comment('商品封面图');
            $table->text('images')->nullable()->comment('商品轮播图');
            $table->text('description')->comment('商品描述');
            $table->decimal('old_price')->comment('原价');
            $table->decimal('group_price')->comment('拼团价');
            $table->unsignedInteger('stock')->comment('库存');
            $table->unsignedInteger('sale_number')->default(0)->comment('销量');
            $table->boolean('on_sale')->default(0)->comment('上架状态');
            $table->unsignedSmallInteger('group_number')->comment('成团人数设置');
            $table->unsignedInteger('open_group_number')->default(0)->comment('已开团数量');
            $table->dateTime('end_time')->comment('拼团截止日期');
            $table->boolean('is_auto')->default(0)->comment('自动成团');
            $table->unsignedInteger('auto_hour')->comment('自动成团时间,以小时为单位');
            $table->unsignedInteger('sort')->default(1)->comment('数值越大展示越靠前');
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
        Schema::dropIfExists('group_goods');
    }
}
