<?php

namespace NotificationChannels\ClickSend;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use NotificationChannels\ClickSend\Exceptions\InvalidConfigException;

class ClickSendServiceProvider extends ServiceProvider
{

    public function boot() {}

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/clicksend-notification-channel.php',
            'clicksend-notification-channel'
        );

        $this->publishes([
            __DIR__.'/../config/clicksend-notification-channel.php' =>
                config_path('clicksend-notification-channel.php')
        ]);

        $this->app->bind(ClickSendConfig::class, function() {
            return new ClickSendConfig($this->app['config']['clicksend-notification-channel']);
        });

        $this->app->singleton(ClickSend::class, function(Application $app) {
           return new ClickSend(
               $app->make(ClickSendConfig::class)
           );
        });

        $this->app->singleton(ClickSendChannel::class, function(Application $app) {
            return new ClickSendChannel(
                $app->make(ClickSend::class),
                $app->make(Dispatcher::class)
            );
        });
    }

    public function provides(): array
    {
        return [
            ClickSendConfig::class,
            ClickSendChannel::class
        ];
    }
}
