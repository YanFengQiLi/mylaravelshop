<?php
/**
 * @author zhenhong~
 * @description 积分商品兑换记录表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntegralGoodsOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('integral_goods_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_no')->unique()->comment('订单编号');
            $table->unsignedInteger('member_id')->index()->comment('用户ID');
            $table->unsignedInteger('number')->comment('兑换数量');
            $table->unsignedInteger('integral_number')->comment('使用积分数量');
            $table->decimal('money')->default(0.00)->comment('使用金钱');
            $table->text('order_address')->comment('订单地址json');
            $table->text('deliver_data')->nullable()->comment('物流信息json');
            $table->string('pay_method')->default(1)->comment('支付方式');
            $table->text('remark')->nullable()->comment('订单附加信息');
            $table->string('refund_no')->unique()->nullable()->comment('退款单号');
            $table->string('pay_no')->nullable()->comment('三方订单号');
            $table->dateTime('paid_at')->nullable()->comment('支付时间');
            $table->string('pay_status')->default(\App\Models\Order::WAIT_PAYING)->comment('支付状态');
            $table->string('deliver_status')->default(\App\Models\Order::WAIT_DELIVER)->comment('物流状态');
            $table->boolean('reviewed')->default(false)->comment('订单是否评价');
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
        Schema::dropIfExists('integral_goods_exchange_record');
    }
}
