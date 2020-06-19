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
            $table->char('account', 11)->unique()->comment('账号-手机号');
            $table->string('email', 40)->unique()->comment('邮箱');
            $table->string('password', 40)->comment('密码');
            $table->string('user_name', 40)->comment('姓名');
            $table->string('nick_name', 40)->comment('昵称');
            $table->tinyInteger('sex')->default(1)->comment('性别');
            $table->integer('photo')->comment('头像');
            $table->tinyInteger('status')->default(0)->comment('状态');
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
