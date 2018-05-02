<?php

namespace App;

trait InsureTrait
{
	   public static function insure($data)
    {
    	$methodName = 'recommendFor' . studly_case($data['code']);
    	$data = $data + [
    	        'expect' => self::getExpect($data['code']),
    	        'recommend' => Policy::$methodName($data['number']),
    	        'user_id' => auth()->id()
    	    ];

    	return Policy::create($data);
    }

    // public static function hasInsured($data)
    // {
    //     $p = Policy::where('code', $data['code'])->where('expect', self::getExpect($data['code']))->first(); 
    //     return $p != null;
    // }

    protected static function getExpect($code)
    {
      return config('lottery.'.$code.'.next');
    }

    public static function recommendForSsq($number)
   {
   		return self::getRandsExcept($number, 1, 16, config('setting.ssq_odds'));
   }

   public static function recommendForFc3d($number)
   {
   		return self::getRandsExcept($number, 0, 999, config('setting.fc3d_odds'));
   }

   protected static function getRandsExcept($number, $min, $max, $odds)
   {
   		$range = range($min, $max);
   		$arr = array_flip($range);
      unset($arr[$number]);
   		return array_rand($arr, $odds);
   }
}