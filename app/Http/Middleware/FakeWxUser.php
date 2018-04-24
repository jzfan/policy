<?php

namespace App\Http\Middleware;

use Closure;
use Overtrue\Socialite\User as SocialiteUser;

class FakeWxUser
{
    public function handle($request, Closure $next)
    {
        $this->make();
        return $next($request);
    }

    protected function make()
    {
        $user = new SocialiteUser([
                        'id' => '123',
                        'name' => 'Fake User',
                        'nickname' => 'Fake Nickname',
                        'avatar' => 'http://via.placeholder.com/20',
                        'email' => null,
                        'original' => [],
                        'provider' => 'WeChat',
                    ]);
        session(['wechat.oauth_user.default' => $user]);
    }
}
