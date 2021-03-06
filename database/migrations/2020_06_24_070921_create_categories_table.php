<?php
/**
 * @author zhenhong~
 * @description 商品分类表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('parent_id')->default(0)->comment('父级ID');
            $table->unsignedInteger('order')->default(0)->comment('排序');
            $table->string('title')->comment('分类标题');
            $table->string('icon')->nullable()->comment('图标');
            $table->tinyInteger('is_index_show')->default(0)->comment('是否设置为首页显示 0-否 1-是');
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
        Schema::dropIfExists('categories');
    }
}
