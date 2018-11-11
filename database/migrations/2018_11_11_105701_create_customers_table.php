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
            $table->string('name')->default(''); // 名称
            $table->string('surname')->default(''); // 姓
            $table->string('phone')->default('');
            $table->string('wechat')->default('');
            $table->string('email')->default('');
            $table->string('address')->default('');
            $table->unsignedTinyInteger('customer_identity_id'); // 身份
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
