<?php

namespace NotificationChannels\Webhook;

use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use NotificationChannels\Webhook\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;

class WebhookChannel
{
    /** @var Client */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\Webhook\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $url = $notifiable->routeNotificationFor('Webhook')) {
            return;
        }

        $webhookData = $notification->toWebhook($notifiable)->toArray();

        $response = $this->client->post($url, [
            'query' => Arr::get($webhookData, 'query'),
            'body' => json_encode(Arr::get($webhookData, 'data')),
            'verify' => Arr::get($webhookData, 'verify'),
            'headers' => Arr::get($webhookData, 'headers'),
        ]);

        if ($response->getStatusCode() >= 300 || $response->getStatusCode() < 200) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($response);
        }
    }
}
