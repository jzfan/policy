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
        $accessToken = $this->oauth->getAccessToken(request('code'));
        $wechatUser = $this->oauth->getUserByToken($accessToken);

        return User::firstOrCreateBy($wechatUser);
    }

    public function url()
    {
        return $this->oauth->redirect()->getTargetUrl();
    }
}