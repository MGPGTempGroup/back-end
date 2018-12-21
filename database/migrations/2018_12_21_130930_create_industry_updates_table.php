<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndustryUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('industry_updates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title'); // 标题
            $table->mediumText('content'); // 内容
            $table->text('first_picture')->nullable(); // 首图（列表项展示图）
            $table->text('top_picture')->nullable(); // 头图（详情页顶部图片）URL
            $table->unsignedInteger('creator_id'); // 创建者id
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
        Schema::dropIfExists('industry_updates');
    }
}
