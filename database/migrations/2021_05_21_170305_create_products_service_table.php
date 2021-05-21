<?php
/**
 * @author zhenhong~
 * 商品服务表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_service', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('icon')->comment('小图标');
            $table->string('title')->comment('服务名称');
            $table->string('content')->comment('描述');
            $table->tinyInteger('status')->comment('状态 0-禁用 1-启用');
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
        Schema::dropIfExists('products_service');
    }
}
