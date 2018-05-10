<?php

namespace App;

trait LotteryCountTrait
{
	public static function countSsqByWinNumber()
	{
	    return self::where('code', 'ssq')->get()
	                        ->groupBy(function ($item) {
	                            return $item->winNumber();
	                    })->transform(function ($item, $key) {
	                        return [
	                                    'number' => $key,
	                                    'count' => $item->count()
	                                ];
	            })->sortBy('number')->values();
	}

	public static function countFc3dByWinNumber()
	{
	    $opencodes = self::where('code', 'fc3d')->select('opencode')->get()->pluck('opencode')
	            ->transform(function ($opencode) {
	                return explode(',', $opencode);
	            });
	    $arr = [];
	    foreach ($opencodes as $opencodeArr) {
	        $arr['bai'][] = $opencodeArr[0];
	        $arr['shi'][] = $opencodeArr[1];
	        $arr['ge'][] = $opencodeArr[2];
	    }
	    $arr = array_map('array_count_values', $arr);
	    $counts = [];
	    foreach ($arr as $index => $row) {
	        foreach ($row as $number => $count) {
	            $counts[$index][] = [
	                'number' => $number,
	                'count' => $count
	            ];
	        }
	    }
	    return $counts;
	}
}