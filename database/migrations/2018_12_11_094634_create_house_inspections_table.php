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
            $table->dateTime('preferred_inspection_datetime')->nullable(); // 预约的日期
            $table->date('preferred_move_in_date')->nullable(); // 期待搬入日期
            $table->string('surname'); // 姓
            $table->string('first_name')->default(''); // 名
            $table->text('comment'); // 留言
            $table->string('mobile'); // 手机号码
            $table->string('mobile_from_country')->default(''); // 手机号码所属国家
            $table->string('email')->default('');
            $table->unsignedInteger('follow_up')->default(0); // 跟进状态，如果已经跟进则填写跟进人id
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
