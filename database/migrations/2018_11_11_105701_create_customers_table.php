<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->nullable(); // 名称
            $table->string('surname'); // 姓
            $table->string('phone')->unique()->nullable();
            $table->string('wechat')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('address')->default('');
            $table->unsignedTinyInteger('identity_id'); // 身份
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
        Schema::dropIfExists('customers');
    }
}
