<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceTestimonialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_testimonials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('surname');
            $table->string('name')->default('');
            $table->string('email');
            $table->string('phone');
            $table->unsignedTinyInteger('identity_id');
            $table->text('comment');
            $table->unsignedTinyInteger('star_level')->default(0); // 评论星级
            $table->unsignedTinyInteger('is_show')->default(0); // 是否展示在前台
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
        Schema::dropIfExists('service_testimonials');
    }
}
