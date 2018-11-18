<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default(''); // 用户名称
            $table->string('surname'); // 姓
            $table->string('phone')->default(''); // 手机号码
            $table->string('email')->default('');
            $table->string('wechat')->default('');
            $table->text('comments'); // 留言内容
            $table->unsignedSmallInteger('identity_id'); // 用户身份id
            $table->unsignedInteger('service_id'); // 所属服务id
            $table->unsignedInteger('remote_address'); // ip地址 - 整型格式
            $table->softDeletes();
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
        Schema::dropIfExists('service_messages');
    }
}
