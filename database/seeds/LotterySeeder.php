<?php

use App\Lottery;
use Illuminate\Database\Seeder;

class LotterySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lottery::create([
            'code' => 'fc3d',
            "expect" => "2018071",
            "opencode" => "7,7,9",
            "opentime" => '2018-03-19 21:20:00'
        ]);
        Lottery::create([
            'code' => 'ssq',
            "expect" => "2018030",
            "opencode" => "13,14,20,21,25,33+07",
            "opentime" => '2018-03-18 21:18:20'
        ]);
    }
}

