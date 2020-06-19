<?php
/**
 * @author zhenhong~
 * @description 用户地址表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_address', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('member_id')->comment('用户ID');
            $table->string('phone',11)->comment('手机号');
            $table->string('name')->comment('收货人姓名');
            $table->string('province')->comment('省');
            $table->string('city')->comment('市');
            $table->string('area')->comment('区');
            $table->string('detail')->comment('详细地址');
            $table->boolean('is_default')->comment('是否是默认地址');
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
        Schema::dropIfExists('member_address');
    }
}
