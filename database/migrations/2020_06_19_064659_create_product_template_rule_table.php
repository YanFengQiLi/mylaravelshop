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
            $table->text('city')->nullable()->comment('城市json');
            $table->unsignedInteger('default_num')->default(0)->comment('默认数量');
            $table->decimal('default_price')->default(0)->comment('默认费用');
            $table->unsignedInteger('add_num')->default(0)->comment('新增数量');
            $table->decimal('add_price')->default(0)->comment('新增费用');
            $table->text('extra')->nullable()->comment('存储特殊扩展字段');
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
