<?php
/**
 * @author zhenhong~
 * 参团成员表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupJoinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_join', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('group_sponsor_id')->index()->comment('发起拼团表ID');
            $table->unsignedInteger('member_id')->index()->comment('用户ID');
            $table->unsignedInteger('group_order_id')->comment('拼团订单ID');
            $table->string('photo')->comment('头像');
            $table->string('nick_name')->comment('昵称');
            $table->boolean('is_leader')->comment('是否是团长');
            $table->dateTime('join_time')->comment('参团时间');
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
        Schema::dropIfExists('group_join');
    }
}
