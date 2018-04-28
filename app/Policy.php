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

    protected static function boot()
    {
        static::created( function ($policy) {
            $policy->user->decrement('tickets_qty');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function wonOrLose($lottery)
    {
    	$all = self::where([
    			'code' => $lottery->code,
                'status' => 'active',
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

    public function toArray()
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'expect' => $this->expect,
            'status' => $this->status,
            'number' => $this->number,
            'number' => $this->number,
            'recommend' => $this->recommend,
        ];
    }
 
}
