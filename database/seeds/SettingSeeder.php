<?php

use App\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
        	'name' => '双色球概率',
        	'key' => 'ssq_odds',
        	'value' => 3,
        ]);
        Setting::create([
        	'name' => '3D概率',
        	'key' => 'fc3d_odds',
        	'value' => 200,
        ]);
    }
}
