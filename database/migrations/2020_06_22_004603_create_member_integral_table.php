<?php
/**
 * @author zhenhong~
 * @description 用户积分明细表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberIntegralTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_integral', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('member_id')->index('member_id')->comment('用户ID');
            $table->char('type',10)->comment('类型,add-加 sub-减');
            $table->string('source')->comment('积分来源');
            $table->unsignedInteger('num')->comment('积分数量');
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
        Schema::dropIfExists('member_integral');
    }
}
