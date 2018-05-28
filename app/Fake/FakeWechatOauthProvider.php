<?php

namespace App\Fake;

use Overtrue\Socialite\Providers\AbstractProvider;
use Pimple\ServiceProviderInterface;
use Overtrue\Socialite\AccessTokenInterface;
use Overtrue\Socialite\ProviderInterface;
use Overtrue\Socialite\User;

class FakeWechatOauthProvider extends AbstractProvider implements ProviderInterface
{

    protected function FakeUser()
    {
        return [
            'id' => '123456',
            'nickname' => 'Fake User',
            'avatar' => 'https://fakeimg.pl/100/'
        ];
    }

    public function getAccessToken($code)
    {
    	return (new Token);
    }

    protected function getAuthUrl($state)
    {
        return 'http://192.168.1.222:8080/oauth/callback?code=iloveyou';
    }

    protected function getTokenUrl()
    {
        return 'http://192.168.1.222:8080/oauth/url';
    }

    protected function getUserByToken(AccessTokenInterface $token)
    {
    	return $this->FakeUser();
    }

    protected function mapUserToObject(array $user)
    {
    	return new User($user);
    }


}

class Token implements AccessTokenInterface
{
	public function getToken()
	{
		return 'valid access token';
	}
}