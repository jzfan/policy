<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    use LotteryCountTrait;
    protected $guarded = [];

    protected static function boot()
    {
    	parent::boot();
    	static::created( function ($lottery) {
            $lottery->policies->each->wonOrLose();
    	});
    }

    public function type()
    {
        if ($this->code == 'ssq') {
            return new Ssq($this->opencode);
        }
        if ($this->code == 'fc3d') {
            return new Fc3d($this->opencode);
        }
    }

    public function policies()
    {
        return $this->hasMany(Policy::class, 'expect', 'expect');
    }

    public static function config()
    {
        $cached = \Cache::remember('lottery', 1, function () {
            $lottery = self::current();
			return $lottery->map( function ($row) {
				        return [
				        	$row['code'] => [
				        		'next' => self::calcNextExpect($row['expect'])
                            ]
				        ];
				    })->collapse();
		});
		config()->set('lottery', $cached);
        return $cached;
    }

    public static function current()
    {
        $group = self::select('code',  \DB::raw('max(expect) as max_expect'))->groupBy('code')->get();
        return $group->map(function($item){
            return self::where(['expect'=> $item->max_expect, 'code'=>$item->code])->get();
        })->collapse();
    }

    public static function calcNextExpect($lastExpect)
    {
    	if (starts_with($lastExpect, date('Y'))) {
    		return $lastExpect + 1;
    	}
    	return date('Y') . '001';
    }

    public static function createIfNewOpen($data)
    {
        return self::firstOrCreate(['code' => $data['code'], 'expect' => $data['expect']], $data);
    }


    public function checkByRecommend($recommend)
    {
        return $this->type()->check($recommend);
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'expect' => $this->expect,
            'opencode' => $this->opencode,
            'created_at' => $this->created_at
        ];
    }
}
