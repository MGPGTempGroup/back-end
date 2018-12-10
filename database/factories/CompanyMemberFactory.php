<?php

use Faker\Generator as Faker;

$factory->define(App\CompanyMember::class, function (Faker $faker) {
    return [
        'surname' => $faker->lastName,
        'name' => $faker->firstName,
        'phone' => $faker->phoneNumber,
        'email' => $faker->email,
        'google_plus_homepage' => $faker->url,
        'linkin_homepage' => $faker->url,
        'introduction' => $faker->text(191),
        'photo' => $faker->imageUrl(461, 450),
        'thumbnail' => $faker->imageUrl(218, 160)
    ];
});
