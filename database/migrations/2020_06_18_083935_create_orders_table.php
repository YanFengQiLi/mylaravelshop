<?php
/**
 * @author zhenhong~
 * @description 订单表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('member_id')->comment('用户ID')->index('member_id');
            $table->unsignedInteger('coupon_code_id')->nullable()->comment('优惠券ID');
            $table->string('order_no')->unique()->comment('订单编号');
            $table->text('order_address')->comment('订单地址json');
            $table->decimal('total_price')->comment('订单总金额');
            $table->string('pay_method')->comment('支付方式');
            $table->string('pay_no')->comment('三方订单号');
            $table->text('remark')->nullable()->comment('订单附加信息');
            $table->string('refund_no')->unique()->nullable()->comment('退款单号');
            $table->dateTime('paid_at')->nullable()->comment('支付时间');
            $table->boolean('closed')->default(false)->comment('订单是否关闭');
            $table->boolean('reviewed')->default(false)->comment('订单是否评价');
            $table->text('deliver_data')->nullable()->comment('物流信息json');
            $table->text('extra')->nullable()->comment('物流附加信息');
            $table->string('pay_status')->default(\App\Models\Order::WAIT_PAYING)->comment('支付状态');
            $table->string('deliver_status')->default(\App\Models\Order::WAIT_DELIVER)->comment('物流状态');
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
        Schema::dropIfExists('orders');
    }
}
