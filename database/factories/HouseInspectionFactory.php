<?php

use Faker\Generator as Faker;

$factory->define(App\HouseInspection::class, function (Faker $faker) {
    return [
        'surname' => $faker->lastName,
        'first_name' => $faker->firstName,
        'comment' => $faker->realText(191),
        'inspection_date' => $faker->date(),
        'inspection_time' => $faker->time(),
        'mobile' => $faker->phoneNumber,
        'house_type' => array_rand(['App\Residence', 'App\Lease'], 1)[0],
        'house_id' => mt_rand(0, 10)
    ];
});
