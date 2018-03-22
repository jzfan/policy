<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'info' => '会员充值',
        'trade_no' => date('YmdHis') . '001',
        'total_fee' => rand(1, 22) * 100,
        'user_id' => function() {
        	return factory('App\User')->create()->id;
        },
        'status' => 'ordered'
    ];
});
