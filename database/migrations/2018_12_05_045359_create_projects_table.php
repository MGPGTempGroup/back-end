<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); // 项目名称
            $table->string('location'); // 位置
            $table->string('address')->default('[]');
            $table->unsignedTinyInteger('status'); // 项目状态
            $table->text('introduction'); // 项目介绍
            $table->string('description')->default(''); // 项目描述
            $table->date('year_built')->nullable(); // 建造年份
            $table->date('estimated_completion_date')->nullable(); // 预计完工日期
            $table->text('broadcast_pictures'); // 轮播图片
            $table->unsignedInteger('min_price');
            $table->unsignedInteger('max_price');
            $table->unsignedInteger('creator_id'); // 数据创建者
            $table->unsignedTinyInteger('is_new_development')->default(0); // 是否是最新开发房产
            $table->unsignedTinyInteger('is_past_success')->default(0); // 是否为已成功项目（是否展示在过去的成功）
            $table->unsignedInteger('owner_id');
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
        Schema::dropIfExists('projects');
    }
}
