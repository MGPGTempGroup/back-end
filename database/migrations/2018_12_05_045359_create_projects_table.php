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
            $table->date('year_built'); // 制造年份
            $table->text('broadcast_pictures'); // 轮播图片
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
