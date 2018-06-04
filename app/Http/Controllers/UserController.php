<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class UserController extends Controller
{
    public function sign()
    {
    	$authUser = auth()->user();
    	if ($authUser->isSignedToday()) {
	    	return 0;
    	}
		$authUser->update(['points' => $authUser->points+10, 'sign_at' => Carbon::now()]);
		return 'success';
    }
}
