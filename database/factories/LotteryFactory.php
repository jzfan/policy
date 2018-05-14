<?php

use Faker\Generator as Faker;

$factory->define(App\Lottery::class, function (Faker $faker) {
    return [
    	'code' => $faker->word,
    	'expect' => '2020' . rand(100, 999),
    	'opencode' => '1,2,3',
    	'opentime' => '2012-01-01 10:00:00'
    ];
});
