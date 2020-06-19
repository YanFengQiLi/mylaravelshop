<?php
/**
 * @author zhenhong~
 * @description 运费模板规则表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTemplateRuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_template_rule', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('product_template_id')->comment('运费模板ID');
            $table->text('city')->comment('城市json');
            $table->unsignedInteger('default_num')->comment('默认数量');
            $table->decimal('default_price')->comment('默认费用');
            $table->unsignedInteger('add_num')->comment('新增数量');
            $table->decimal('add_price')->comment('新增费用');
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
        Schema::dropIfExists('product_template_rule');
    }
}
