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
            \App\Setting::config();
            \App\Lottery::config();
        }
        if (env('APP_DEBUG')) {
            // app('wechat.official_account')
            $this->app->instance('wechat.official_account', new \App\FakeOfficialAccount);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
