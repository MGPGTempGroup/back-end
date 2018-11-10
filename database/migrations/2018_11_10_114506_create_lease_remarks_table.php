<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaseRemarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lease_remarks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admin_user_id'); // 管理用户id
            $table->text('content'); // 留言内容
            $table->unsignedInteger('lease_id'); // 租赁房屋id
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
        Schema::dropIfExists('lease_remarks');
    }
}
