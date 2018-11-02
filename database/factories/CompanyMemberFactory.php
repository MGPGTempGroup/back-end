<?php

use Faker\Generator as Faker;

$factory->define(App\CompanyMember::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phone,
        'google_plus_homepage' => $faker->url,
        'linkin_homepage' => $faker->url,
        'introduction' => $faker->text,
        'photo' => $faker->imageUrl(461, 450),
        'thumbnail' => $faker->imageUrl(218, 160)
    ];
});
