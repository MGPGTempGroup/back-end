<?php

use Faker\Generator as Faker;

$factory->define(App\CompanyInfo::class, function (Faker $faker) {
    $emptyObj = new \stdClass();
    return [
        'company_name' => '',
        'telephone' => '',
        'facsimile' => '',
        'address' => [],
        'detailed_address' => '',
        'post_code' => '',
        'regionalism_code' => '',
        'opening_hours' => [
            'monday' => $emptyObj,
            'tuesday' => $emptyObj,
            'wednesday' => $emptyObj,
            'thursday' => $emptyObj,
            'friday' => $emptyObj,
            'saturday' => $emptyObj,
            'sunday' => $emptyObj
        ],
        'service_time' => '',
        'google_plus_homepage' => '',
        'linkin_homepage' => '',
        'youtube_homepage' => '',
        'facebook_homepage' => '',
        'twitter_homepage' => '',
        'instagram_homepage' => ''
    ];
});
