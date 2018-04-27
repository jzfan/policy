<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrepayRank extends Model
{
    protected $guarded = [];

    public static function sold($order)
    {
    	$rank = self::where('price', $order->total_fee)->first();
    	$order->user->update(['tickets_qty' => $rank->tickets_qty]);
    }
}
