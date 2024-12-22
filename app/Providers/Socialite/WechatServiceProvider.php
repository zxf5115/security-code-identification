<?php
namespace App\Providers\Socialite;

use Illuminate\Support\ServiceProvider;

class WechatServiceProvider extends ServiceProvider
{
    public function boot()
    {
       $this->app->make('Laravel\Socialite\Contracts\Factory')->extend('wechat', function ($app) {
            $config = $app['config']['services.wechat'];
            return new WechatProvider(
                $app['request'], $config['client_id'],
                $config['client_secret'], $config['redirect']
            );
       });
    }
    public function register()
    {

    }
}
