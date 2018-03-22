<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    use InsureTrait;
    
	protected $guarded = [];
    protected $casts = [
        'recommend' => 'array'
    ];

    public static function wonOrLose($lottery)
    {
    	$all = self::where([
    			'code' => $lottery->code,
    			'expect' => $lottery->expect,
    		])->get();
    	foreach ($all as $one) {
    		if (in_array($lottery->tail(), $one->recommend)) {
    			$one->update(['status' => 'won']);
    		} else {
    			$one->update(['status' => 'lose']);
    		}
    	}
    }
 
}
