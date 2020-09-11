<?php
/**
 * @author zhenhong~
 * 发起拼团表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupSponsorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_sponsor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('member_id')->index()->comment('用户ID');
            $table->unsignedInteger('group_goods_id')->index()->comment('拼团商品ID');
            $table->unsignedSmallInteger('group_number')->default(0)->comment('成团人数');
            $table->unsignedSmallInteger('join_number')->default(1)->comment('参团人数');
            $table->unsignedInteger('status')->default(1)->comment('状态');
            $table->dateTime('end_time')->comment('结束时间');
            $table->dateTime('auto_time')->nullable()->comment('自动成团时间');
            $table->unsignedTinyInteger('status')->comment('状态');
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
        Schema::dropIfExists('group_sponsor');
    }
}
