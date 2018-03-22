<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	protected $guarded = [];

	public static function config()
	{
		$setting = \Cache::remember('setting', 60, function () {
		    return self::pluck('value', 'key')->all();
		});
		config()->set('setting', $setting);
	}
}
