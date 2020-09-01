<?php
/**
 * @author zhenhong~
 * 连续签到记录表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberSeriesSignRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_series_sign_record', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('member_id')->index('member_id')->comment('用户ID');
            $table->unsignedInteger('sign_day')->comment('连续签到天数');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_series_sign_record');
    }
}
