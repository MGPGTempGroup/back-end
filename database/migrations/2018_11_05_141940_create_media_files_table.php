<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path');
            $table->string('url')->nullable();
            $table->string('key')->unique();
            $table->string('mime_type');
            $table->string('suffix');
            $table->unsignedTinyInteger('media_file_type')->default(0); // 媒体文件类型 default 图片
            $table->unsignedTinyInteger('storage_mode')->default(0); // 存储方式 default 本地
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
        Schema::dropIfExists('media_files');
    }
}
