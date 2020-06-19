<?php
/**
 * @author zhenhong~
 * @description 用户产品收藏表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberFavoriteProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_favorite_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('member_id')->comment('用户ID')->index('member_id');
            $table->unsignedInteger('product_id')->comment('产品ID')->index('product_id');
            $table->index([
                'member_id',
                'product_id'
            ]);
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
        Schema::dropIfExists('member_favorite_products');
    }
}
