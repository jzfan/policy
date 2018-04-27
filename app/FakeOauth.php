<?php

namespace App;

class FakeOauth
{
    public function redirect()
    {
        return $this;
    }

    public function getTargetUrl()
    {
        return 'http://192.168.1.222:8080/oauth/callback?code=iloveyou';
    }

    public function getUserByToken($accessToken)
    {
        return [
            'openid' => '123456',
            'nickname' => 'Fake User',
            'headimgurl' => 'https://fakeimg.pl/100/'
        ];
    }

    public function getAccessToken($code)
    {
        return 'valid access token';
    }
}