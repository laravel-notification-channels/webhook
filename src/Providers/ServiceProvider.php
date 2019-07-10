<?php

namespace NotificationChannels\Webhook\Providers;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use NotificationChannels\Webhook\WebhookChannel;
use Illuminate\Support\ServiceProvider as BaseProvider;

class ServiceProvider extends Baseprovider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('webhook-notifications.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'webhook-notifications'
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app
            ->when(WebhookChannel::class)
            ->needs(ClientInterface::class)
            ->give(function ($app) {
                return new Client($app['config.webhook-notifications']['default-config']);
            });
    }
}
