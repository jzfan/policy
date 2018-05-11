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
    		Policy::wonOrLose($lottery);
    	});
    }

    public static function config()
    {
        $lottery = self::current();
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

    public function tail()
    {
    	$arr = preg_split('/[,+]/', $this->opencode);
    	return (int)array_pop($arr);
    }

    public function winNumber()
    {
        if ($this->code == 'ssq') {
            return (int)explode('+', $this->opencode)[1];
        }
        if ($this->code == 'fc3d') {
            return (int)str_replace(',', '', $this->opencode);
        }
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
