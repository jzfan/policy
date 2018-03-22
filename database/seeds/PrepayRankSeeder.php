<?php

use App\PrepayRank;
use Illuminate\Database\Seeder;

class PrepayRankSeeder extends Seeder
{

    public function run()
    {
        PrepayRank::create([
            'tickets_qty' => 11,
            'price' => 1000,
        ]);
        PrepayRank::create([
            'tickets_qty' => 23,
            'price' => 2000,
        ]);
        PrepayRank::create([
            'tickets_qty' => 60,
            'price' => 5000,
        ]);
        PrepayRank::create([
            'tickets_qty' => 125,
            'price' => 10000,
        ]);
    }
}
