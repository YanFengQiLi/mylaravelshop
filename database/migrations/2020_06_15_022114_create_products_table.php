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
            $table->string('image')->comment('商品封面图');
            $table->boolean('on_sale')->default(true)->comment('上架状态');
            $table->float('rating')->default(5)->comment('商品评分');
            $table->unsignedInteger('sold_count')->default(0)->comment('销量');
            $table->unsignedInteger('review_count')->default(0)->comment('评论数');
            $table->decimal('price', 10, 2)->comment('价格');
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
