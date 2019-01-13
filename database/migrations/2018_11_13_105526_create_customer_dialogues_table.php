<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerDialoguesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_dialogues', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid'); // 客户与管理员每次完整对话的uuid
            $table->string('name'); // 客户名称
            $table->string('email'); // 客户邮箱
            $table->string('nickname');
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
        Schema::dropIfExists('customer_dialogues');
    }
}
