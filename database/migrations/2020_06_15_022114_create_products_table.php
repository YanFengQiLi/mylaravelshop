<?php
/**
 *  @author zhenghong~
 *  @description 商品表
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('商品名称');
            $table->text('description')->comment('商品描述');
            $table->string('image')->nullable()->comment('商品封面图');
            $table->text('pictures')->nullable()->comment('商品轮播图');
            $table->boolean('on_sale')->default(true)->comment('上架状态');
            $table->float('rating')->default(5)->comment('商品评分');
            $table->unsignedInteger('sold_count')->default(0)->comment('销量');
            $table->unsignedInteger('review_count')->default(0)->comment('评论数');
            $table->decimal('price', 10, 2)->comment('价格');
            $table->unsignedInteger('grand_id')->comment('顶级ID');
            $table->unsignedInteger('parent_id')->comment('父级ID');
            $table->unsignedInteger('category_id')->comment('子级ID');
            $table->string('concat_id')->comment('以逗号连接分类ID');
            $table->unsignedTinyInteger('product_template_id')->comment('运费模板ID');
            $table->tinyInteger('is_join_vip')->default(0)->comment('是否参与 vip 年卡活动,0-否 1-是');
            $table->tinyInteger('is_join_integral')->default(0)->comment('是否参与下单得积分活动,0-否 1-是');
            $table->string('service')->nullable()->comment('商品服务');
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
        Schema::dropIfExists('products');
    }
}
