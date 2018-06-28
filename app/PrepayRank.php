<?php

namespace App;

use App\Balance;
use Illuminate\Database\Eloquent\Model;

class PrepayRank extends Model
{
    protected $guarded = [];

    public static function sold($order)
    {
    	\DB::transaction(function () use ($order) {
	    	// $tickets_qty = self::where('price', $order->total_fee)->value('tickets_qty');
	    	$order->user->increment('rank');
	    	$order->update(['status' => 'paid', 'paid_at' => now()]);
	    	Balance::create([
	    	        'user_id' => $order->user_id,
	    	        'type' => '充值',
	    	        'amount' => $order->total_fee
	    	    ]);
		});
    }
}
