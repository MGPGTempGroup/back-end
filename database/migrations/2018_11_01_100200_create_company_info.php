<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name')->nullable(); // 公司名称
            $table->string('telephone')->nullable(); // 固话
            $table->string('facsimile')->nullable(); // 传真
            $table->string('address')->nullable(); // 公司地址
            $table->string('post_code')->nullable(); // 邮编
            $table->string('regionalism_code')->nullable(); // 行政区划代码
            $table->string('opening_hours')->nullable(); // 总部开放时间
            $table->string('service_time')->nullable(); // 服务时间
            // 相关社交主页
            $table->string('google_plus_homepage')->nullable();
            $table->string('linkin_homepage')->nullable();
            $table->string('youtube_homepage')->nullable();
            $table->string('facebook_homepage')->nullable();
            $table->string('twitter_homepage')->nullable();
            $table->string('instagram_homepage')->nullable();
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
        Schema::dropIfExists('company_info');
    }
}
