<?php

use Faker\Generator as Faker;

$factory->define(App\AdminUser::class, function (Faker $faker) {
    return [
        'email_verified_at' => now(),
        'password' => Hash::make('123456'),
        'remember_token' => str_random(10)
    ];
});
