<?php

use Faker\Generator as Faker;

$factory->define(App\Policy::class, function (Faker $faker) {
    return [
        'user_id' => function () {
        	return factory('App\User')->create()->id;
        },
        'expect' => '20120001',
        'number' => rand(100, 999),
        'code' => $faker->word,
        'recommend' => array_random(range(0, 99), rand(2, 5))
    ];
});
