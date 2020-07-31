<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @author zhnehong~
 * @description 管理员消息表
 * Class CreateAdminMessageTable
 */
class CreateAdminMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_messages',function (Blueprint $table){
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('type')->index()->comment('消息类型');
            $table->string('title')->comment('消息名称');
            $table->text('extra')->comment('存储扩展信息');
            $table->boolean('status')->default(0)->comment('状态');
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
        Schema::dropIfExists('admin_message');
    }
}
