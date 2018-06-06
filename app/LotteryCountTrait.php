<?php

namespace App;

trait LotteryCountTrait
{
	public static function checkUserRankForLimit($limit, $by)
	{
		if ($by == 'input' && auth()->user() != null && auth()->user()->rank >= 4) {
			return true;
		}
		if ($by == 'select') {
			switch (auth()->user() != null ? auth()->user()->rank : 1) {
				default:
				case 1:
					$max_limit = 50;
					break;
				case 2:
					$max_limit = 100;
					break;
				case 3:
					$max_limit = 200;
					break;
				case 4:
					return true;
			}
			return $max_limit >= $limit;
		}
		return false;
	}

	public static function countSsq($take)
	{
		$ssq = self::groupByColor($take);
		$blue = self::formatCount($ssq->pluck('blue'));
		$red = self::formatCount($ssq->pluck('red')->collapse());
		return compact(['blue', 'red']);
	}
	protected static function groupByColor($take)
	{
		return self::select(['id', 'opencode'])->where('code', 'ssq')->take($take)->get()
						->transform( function($item) {
							$balls = self::getSsqBalls($item->opencode);
							return [
									'id' => $item->id,
									'red' => $balls['red'],
									'blue' => $balls['blue'],
								];
						});
	}
	protected static function formatCount($group)
	{
		return collect(array_count_values($group->toArray()))->transform( function ($value, $key) {
					return [
						'number' => $key,
						'count' => $value
					];
				})->values();
	}
	protected static function getSsqBalls($opencode)
	{
		$explode = explode('+', $opencode);
		$red = explode(',', $explode[0]);
		$blue = (int)$explode[1];
		return compact(['blue', 'red']);
	}

	public static function countFc3d($take)
	{
	    $opencodes = self::where('code', 'fc3d')->select('opencode')->take($take)->get()->pluck('opencode')
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