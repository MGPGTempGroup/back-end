<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHouseInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('house_inspections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('house_type'); // 所属房屋类别：residence or lease 出售与租赁
            $table->unsignedInteger('house_id'); // 所属房屋id
            $table->date('inspection_date')->nullable(); // 预约的日期
            $table->time('inspection_time')->nullable(); // 预约的时间
            $table->string('surname'); // 姓
            $table->string('first_name')->default(''); // 名
            $table->text('comment'); // 留言
            $table->string('mobile'); // 手机号码
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
        Schema::dropIfExists('house_inspections');
    }
}
