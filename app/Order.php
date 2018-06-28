<?php

namespace App;

use App\Balance;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    public $timestamps = ['paid_at'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function scopeOrdered($q)
    {
    	return $q->where('status', 'ordered');
    }

    public function active()
    {
    	\DB::transaction(function () {
	    	$this->user->increment('rank');
	    	$this->user->increment('rank_remain');
	    	$this->update(['status' => 'paid', 'paid_at' => now()]);
	    	Balance::create([
	    	        'user_id' => $this->user_id,
	    	        'type' => '充值',
	    	        'amount' => $this->total_fee
	    	    ]);
		});
    }
}
