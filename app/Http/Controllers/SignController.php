<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class SignController extends Controller
{
    public function sign()
    {
    	$authUser = auth()->user();
    	if ($authUser->isSignedToday()) {
	    	return 0;
    	}
    	$sign_continuly = $this->getSignContinuly($authUser->sign_at, $authUser->sign_continuly);
		$authUser->update([
			'points' => $this->getSignPoints($authUser->points, $sign_continuly),
			'sign_at' => Carbon::now(),
			'sign_continuly' => $sign_continuly
		]);
		return $authUser;
    }

    protected function getSignContinuly($sign_at, $days)
    {
    	if (!Carbon::parse($sign_at)->isYesterday() || $days >= count(config('global.signed_points_arr'))) {
    		return 1;
    	}
    	return $days + 1;
    }

    protected function getSignPoints($points, $days)
    {
    	return $points + config('global.signed_points_arr')[$days-1];
    }
}
