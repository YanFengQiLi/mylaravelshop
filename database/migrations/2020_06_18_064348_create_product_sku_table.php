<?php
/**
 * @author zhenhong~
 * @description 商品sku表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSkuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sku', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->comment('sku名称');
            $table->string('description')->comment('sku描述');
            $table->decimal('price', 10,2)->comment('sku价格');
            $table->unsignedInteger('stock')->comment('sku库存');
            $table->unsignedInteger('product_id')->comment('商品ID');
            $table->text('img')->comment('sku图片');
            $table->text('img_icon')->comment('sku小图片');
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
        Schema::dropIfExists('product_sku');
    }
}
