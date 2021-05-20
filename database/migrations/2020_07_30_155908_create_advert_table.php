<?php
/**
 * @author zhenhong~
 * @description 广告表
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advert', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->default('')->comment('广告名称');
            $table->unsignedTinyInteger('type')->index()->comment('广告类型');
            $table->string('links')->nullable()->default('')->comment('链接地址');
            $table->boolean('status')->default(0)->comment('状态 1-启用 0-禁用');
            $table->string('image')->nullable()->default('')->comment('图片地址');
            $table->integer('sort')->default(1)->comment('排序');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advert');
    }
}
