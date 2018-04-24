<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class WxOauthController extends Controller
{
    public function index()
    {
    	$wxUser = session('wechat.oauth_user.default');
    	$user = User::where('openid', $wxUser->id)->first();
    	if (!$user) {
    		User::create([
    			'name' => $wxUser->nickname,
                'api_token' => str_random(60),
                'openid' => $wxUser->id,
                'avatar' => $wxUser->avatar
    		]);
    	}
    	return response()->json([
    		'api_token' => $wxUser->id,
    		'name' => $wxUser->nickname,
    		'avatar' => $wxUser->avatar
    	]);
    }
}
