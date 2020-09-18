<?php
/**
 * @author zhenhong~
 * 拼团订单表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_no')->unique()->comment('订单编号');
            $table->unsignedInteger('member_id')->index()->comment('用户ID');
            $table->text('address')->comment('订单地址json');
            $table->unsignedInteger('buy_number')->default(1)->comment('购买数量');
            $table->decimal('total_price')->comment('订单总金额');
            $table->string('pay_method')->comment('支付方式');
            $table->string('pay_no')->comment('三方订单号');
            $table->text('remark')->nullable()->comment('订单附加信息');
            $table->string('refund_no')->unique()->nullable()->comment('退款单号');
            $table->boolean('closed')->default(false)->comment('订单是否关闭');
            $table->boolean('is_reviewed')->default(false)->comment('订单是否评价');
            $table->text('deliver_data')->nullable()->comment('物流信息json');
            $table->text('extra')->nullable()->comment('物流附加信息');
            $table->string('pay_status')->default(\App\Services\BaseOrderService::WAIT_PAYING)->comment('支付状态');
            $table->string('deliver_status')->default(\App\Services\BaseOrderService::WAIT_DELIVER)->comment('物流状态');
            $table->dateTime('paid_at')->nullable()->comment('支付时间');
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
        Schema::dropIfExists('group_order');
    }
}
