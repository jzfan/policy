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

    protected static function getExpect($code)
    {
      return config('lottery.'.$code.'.next');
    }

    public static function recommendForSsq($number)
   {
   		$blue = self::getRandsExcept($number, 1, 16);
      $red = array_random(range(1, 33), 3);
      return compact(['red', 'blue']);
   }

   public static function recommendForFc3d($number)
   {
      $str = str_pad($number, 3, '0', STR_PAD_LEFT);
   		return [
          'bai' => self::getRandsExcept($str[0], 0, 9),
          'shi' => self::getRandsExcept($str[1], 0, 9),
          'ge' => self::getRandsExcept($str[2], 0, 9)
      ]; 
        
   }

   protected static function getRandsExcept($number, $min, $max, $odds=3)
   {
   		$range = range($min, $max);
   		$arr = array_flip($range);
      unset($arr[(int)$number]);
   		return array_rand($arr, $odds);
   }
}