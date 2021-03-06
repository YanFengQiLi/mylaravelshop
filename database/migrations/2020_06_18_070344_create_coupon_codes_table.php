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
            $table->string('use_type',30)->comment('使用范围');
            $table->text('use_type_id')->nullable()->comment('特定商品祖父级ID数组');
            $table->string('value')->comment('折扣');
            $table->unsignedInteger('total')->comment('券总量');
            $table->unsignedInteger('used')->default(0)->comment('券使用量');
            $table->decimal('min_amount',10,2)->comment('最低使用金额');
            $table->tinyInteger('is_limit_time')->default(1)->comment('是否限制使用日期 0-否 1-是');
            $table->dateTime('before_time')->nullable()->comment('开始时间');
            $table->dateTime('after_time')->nullable()->comment('结束时间');
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
