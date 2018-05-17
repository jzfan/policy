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
        $max_ids = self::select('code',  \DB::raw('max(id) as max_id'))->groupBy('code')->get()->pluck('max_id');
        return self::whereIn('id', $max_ids)->get();
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
            'created_at' => $this->created_at->format('Y-m-d')
        ];
    }
}
