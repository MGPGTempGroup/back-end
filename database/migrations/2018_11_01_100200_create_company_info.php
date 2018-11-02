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
            $table->string('company_name'); // 公司名称
            $table->string('telephone'); // 固话
            $table->string('facsimile'); // 传真
            $table->string('address'); // 公司地址
            $table->string('post_code'); // 邮编
            $table->string('regionalism_code'); // 行政区划代码
            $table->string('opening_hours'); // 总部开放时间
            $table->string('service_time'); // 服务时间
            // 相关社交主页
            $table->string('google_plus_homepage');
            $table->string('linkin_homepage');
            $table->string('youtube_homepage');
            $table->string('facebook_homepage');
            $table->string('twitter_homepage');
            $table->string('instagram_homepage');
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
