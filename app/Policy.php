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

    // protected static function boot()
    // {
    //     static::created( function ($policy) {
    //         $policy->user->decrement('tickets_qty');
    //     });
    // }

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
            $winNumber = $lottery->winNumber();
    		if (in_array($winNumber, $one->recommend)) {
    			$one->update(['status' => 'won', 'win_number' => $winNumber]);
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
            'win_number' => $this->win_number,
            'recommend' => $this->recommend,
            'created_at' => $this->created_at->format('Y-m-d H:i'),
        ];
    }
 
}
