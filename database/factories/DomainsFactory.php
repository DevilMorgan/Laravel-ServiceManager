<?php

use Faker\Generator as Faker;

$factory->define(App\Domains::class, function (Faker $faker) {
    return [
        'url' => $faker->domainName,
        'domain' => factory(App\Providers::class)->make(),
        'hosting' => factory(App\Providers::class)->make(),
        'deadline' => $faker->dateTimeThisYear(),
        'amount' => $faker->randomFloat(2, 0, 200),
        'payed' => $faker->boolean,
        'note' => $faker->sentence,
        'user_id' => factory(App\User::class)->make(),
    ];
});
