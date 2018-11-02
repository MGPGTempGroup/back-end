<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResidencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('residences', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name'); // 房屋名称
            $table->unsignedTinyInteger('property_type'); // 房屋类型
            $table->text('introduction')->nullable(); // 房屋简短介绍
            $table->unsignedInteger('floor_space')->nullable(); // 房屋面积
            $table->mediumText('details'); // 房屋详情
            $table->text('broadcast_pictures'); // 房屋环境图片

            $table->string('country_code'); // 国家代码
            $table->string('state_code'); // 州代码
            $table->string('city_code'); // 市代码
            $table->string('part_name'); // 地区名称
            $table->string('street_name'); // 街道名称
            $table->string('street_code'); // 街道号码
            $table->string('house_number'); // 门牌号
            $table->string('post_code'); // 邮政编码
            $table->string('detailed_address'); // 详细地址
            $table->string('address_description')->nullable(); // 地址额外描述

            $table->point('map_coordinates'); // 详细地图坐标

            $table->unsignedTinyInteger('bedrooms')->default(0); // 卧室数量
            $table->unsignedtinyInteger('bathrooms')->default(0); // 淋浴数量
            $table->unsignedTinyInteger('car_ports')->default(0); // 车位数量
            $table->unsignedTinyInteger('lockup_garages')->default(0); // 车库数量

            $table->unsignedInteger('min_price'); // 最小价格
            $table->unsignedInteger('max_price'); // 最大价格

            $table->dateTime('upcoming_inspections_start_time')->nullable(); // 即将到来的检查开始时间
            $table->dateTime('upcoming_inspections_end_time')->nullable(); // 即将到来的检查结束时间
            $table->dateTime('available_date'); // 可用日期
            $table->dateTime('constructed_in')->nullable(); // 修建时间
            $table->dateTime('built_in')->nullable(); // 建成时间

            $table->unsignedInteger('sort_number')->default(0); // 排序号码

            $table->unsignedTinyInteger('show')->default(1); // 当前状态：展示与隐藏
            $table->unsignedTinyInteger('is_new_development')->default(0); // 是否是最新开发房产
            $table->unsignedTinyInteger('state')->default(1); // 房屋状态

            // 统计相关
            $table->unsignedInteger('pv')->defualt(0);
            $table->unsignedInteger('uv')->default(0);

            $table->unsignedInteger('owner_id'); // 物主id

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
        Schema::dropIfExists('residences');
    }
}
