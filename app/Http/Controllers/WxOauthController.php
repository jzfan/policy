<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class WxOauthController extends Controller
{
    protected $oauth;

    public function __construct()
    {
        $this->oauth = app('wechat.official_account')->oauth;
    }

    public function user()
    {
        $accessToken = $this->token(request('code'));
        $wechatUser = $this->oauth->getUserByToken($accessToken);
        \Log::info($wechatUser['headimgurl']);
        $user = User::where('openid', $wechatUser['openid'])->firstOrCreate([
                'openid' => $wechatUser['openid']
            ], [
                'name' => $wechatUser['nickname'],
                'api_token' => str_random(60),
                'openid' => $wechatUser['openid'],
                'avatar' => $wechatUser['headimgurl']
            ]);
        return response()->json([
            'api_token' => $user->api_token,
            'name' => $user->name,
            'avatar' => $user->avatar
        ]);
    }

    protected function token()
    {
        $accessToken = $this->oauth->getAccessToken(request('code'));
        // \Log::info(json_encode($accessToken));
        return $accessToken;
        // $wxUser = session('wechat.oauth_user.default');
    }

    public function url()
    {
        return $this->oauth->redirect()->getTargetUrl();
    }
}