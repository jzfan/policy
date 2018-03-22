<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{

    protected $guarded = [];

    protected static function boot()
    {
    	parent::boot();
    	static::updated( function ($lottery) {
    		Policy::wonOrLose($lottery);
    	});
    }

    public static function config()
    {
		$lottery = self::groupBy('code')->orderBy('id', 'desc')->get();
		$cached = \Cache::remember('lottery', 1, function () use ($lottery) {
			return $lottery->map( function ($row) {
				        return [ 
				        	$row['code'] => [
				        		'next' => self::calcNextExpect($row['expect'])
				        	]
				        ];
				    })->collapse();
		});
		config()->set('lottery', $cached);
    }

    public static function calcNextExpect($lastExpect)
    {
    	if (starts_with($lastExpect, date('Y'))) {
    		return $lastExpect + 1;
    	}
    	return date('Y') . '001';
    }

    public static function updateIfNewOpen($data)
    {
        $lottery = self::firstOrCreate(['code' => $data['code']], $data);
            // dump($lottery->toArray());
        if ($lottery->expect != $data['expect']) {
            $lottery->update($data);
        }
		return $lottery;
    }

    public function tail()
    {
    	$arr = preg_split('/[,+]/', $this->opencode);
    	return array_pop($arr);
    }
}
