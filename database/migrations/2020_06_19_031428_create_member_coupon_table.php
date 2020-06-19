<?php
/**
 * @author zhenhong~
 * @description 用户优惠券表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_coupon', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('member_id')->comment('用户ID');
            $table->unsignedInteger('coupon_code_id')->comment('优惠券ID');
            $table->boolean('overdue')->default(false)->comment('是否过期');
            $table->dateTime('over_time')->comment('过期时间');
            $table->string('use_status')->comment('优惠券状态');
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
        Schema::dropIfExists('member_coupon');
    }
}
