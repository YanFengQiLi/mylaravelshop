<?php
/**
 * @author zhenhong~
 * @description 运费模板表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_template', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->comment('模板名称');
            $table->unsignedTinyInteger('type')->comment('类型 0-自定义运费 1-包邮');
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
        Schema::dropIfExists('product_template');
    }
}
