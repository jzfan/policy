<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (app()->environment() !== 'testing') {
            // \App\Setting::config();
            \App\Lottery::config();
        }
        if (env('APP_DEBUG') || app()->environment() === 'testing') {
            // $this->app->instance('wechat.official_account', new \App\Fake\FakeOfficialAccount);
            $this->app['wechat.official_account']['oauth'] = new \App\Fake\FakeWechatOauthProvider(
                new \Symfony\Component\HttpFoundation\Request, null, null
            );
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Billing\PaymentGateway', function ($app) {
            return new \App\Billing\WxPaymentGateway;
        });
    }
}
