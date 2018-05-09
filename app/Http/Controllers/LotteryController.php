<?php

namespace App\Http\Controllers;

use App\Lottery;
use Illuminate\Http\Request;

class LotteryController extends Controller
{

    public function countGroupBy()
    {
    	$data = request()->validate([
    		'code' => 'required'
    	]);
    	$group = Lottery::where($data)->get()
	    			->groupBy(function ($item) {
	    				// dd($item->winNumber());
			    		return $item->winNumber();
		    	});
	    return $group;

    }


}
