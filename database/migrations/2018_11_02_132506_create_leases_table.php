<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leases', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name'); // 房屋名称
            $table->text('brief_introduction')->nullable(); // 房屋简短介绍
            $table->unsignedInteger('floor_space')->nullable(); // 房屋面积
            $table->mediumText('details'); // 房屋详情
            $table->text('broadcast_pictures'); // 房屋环境图片

            $table->string('address'); // 地址
            $table->string('country_code')->default('AUS'); // 国家代码，默认为澳大利亚
            $table->string('state_code')->default(''); // 州代码
            $table->string('city_code')->default(''); // 市代码
            $table->string('suburb_name')->nullable(); // 郊区名称
            $table->string('street_name')->nullable(); // 街道名称
            $table->string('street_code')->nullable(); // 街道号码
            $table->string('house_number')->nullable(); // 门牌号
            $table->string('post_code'); // 邮政编码
//            $table->string('detailed_address')->nullable(); // 详细地址
            $table->string('address_description')->nullable(); // 地址额外描述

            $table->string('map_coordinates')->nullable(); // 详细地图坐标

            $table->unsignedTinyInteger('bedrooms')->default(0); // 卧室数量
            $table->unsignedTinyInteger('bathrooms')->default(0); // 淋浴数量
            $table->unsignedTinyInteger('car_spaces')->default(0); // 车位数量
            $table->unsignedTinyInteger('lockup_garages')->default(0); // 车库数量

            // 月租金
            $table->unsignedInteger('per_month_min_price')->nullable();
            $table->unsignedInteger('per_month_max_price')->nullable();

            // 周租金
            $table->unsignedInteger('per_week_min_price')->nullable();
            $table->unsignedInteger('per_week_max_price')->nullable();

            // 日租金
            $table->unsignedInteger('per_day_min_price')->nullable();
            $table->unsignedInteger('per_day_max_price')->nullable();

            $table->text('upcoming_inspection_datetime')->nullable(); // 可用检查时间
            $table->dateTime('available_start_date')->nullable(); // 可用日期
            $table->dateTime('available_end_date')->nullable(); // 可用日期

            $table->unsignedInteger('sort_number')->default(0); // 排序号码

            $table->unsignedTinyInteger('show')->default(1); // 当前状态：展示与隐藏
            $table->unsignedTinyInteger('state')->default(1); // 房屋状态

            $table->text('video_embedded_code')->nullable(); // 视频嵌入代码

            // 统计相关
            $table->unsignedInteger('pv')->nullable();
            $table->unsignedInteger('uv')->nullable();

            $table->unsignedInteger('owner_id'); // 物主id
            $table->unsignedInteger('creator_id'); // 数据创建者id

            $table->softDeletes(); // deleted_at

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
        Schema::dropIfExists('leases');
    }
}
