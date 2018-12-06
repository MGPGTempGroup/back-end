<?php

use Faker\Generator as Faker;

$factory->define(App\PropertyOwner::class, function (Faker $faker) {
    return [
        'surname' => $faker->lastName,
        'name' => $faker->firstName,
        'wechat' => str_random(10),
        'id_card' => str_random(18),
        'phone' => $faker->phoneNumber,
        'email' => $faker->email,
        'address' => ['Australia', 'Northern Region', 'Darwin'],
        'identity_id' => mt_rand(1,5)
    ];
});
