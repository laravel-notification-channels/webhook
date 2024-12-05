<?php

namespace NotificationChannels\Webhook;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Notification;

class WebhookMessageServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        Notification::extend('webhook', static function (Container $app) {
            return $app->make(WebhookChannel::class);
        });
    }
}
