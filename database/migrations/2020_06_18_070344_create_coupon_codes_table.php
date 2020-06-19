<?php
/**
 * @author  zhenhong~
 * @description 优惠券表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('优惠券名称');
            $table->string('code')->unique()->comment('优惠券码');
            $table->string('type')->comment('券类型');
            $table->string('value')->comment('折扣');
            $table->unsignedInteger('total')->comment('券总量');
            $table->unsignedInteger('used')->default(0)->comment('券使用量');
            $table->decimal('min_amount',10,2)->comment('最低使用金额');
            $table->dateTime('before_time')->comment('开始时间');
            $table->dateTime('after_time')->comment('结束时间');
            $table->boolean('enable')->comment('是否启动 1-是 0-否');
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
        Schema::dropIfExists('coupon_codes');
    }
}
