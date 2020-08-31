<?php
/**
 * @author zhenhong~
 * 用户签到表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberSignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_sign', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('member_id')->index('member_id')->comment('用户ID');
            $table->date('sign_date')->comment('签到日期');
            $table->unsignedInteger('number')->comment('获得积分数量');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_sign');
    }
}
