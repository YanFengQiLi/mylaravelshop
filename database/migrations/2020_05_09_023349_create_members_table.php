<?php
/**
 *  @author zhenghong~
 *  @description 用户表
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->integer('id', true);
            $table->char('account', 11)->nullable()->unique()->comment('账号-手机号');
            $table->string('email', 40)->nullable()->unique()->comment('邮箱');
            $table->string('password', 100)->nullable()->comment('密码');
            $table->string('user_name', 40)->nullable()->comment('姓名');
            $table->string('nick_name', 40)->nullable()->comment('昵称');
            $table->tinyInteger('sex')->default(1)->comment('性别 1-男 2-女');
            $table->string('photo')->nullable()->comment('头像');
            $table->tinyInteger('status')->default(1)->comment('状态 0-冻结 1-正常');
            $table->unsignedInteger('integral')->default(0)->comment('积分');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
