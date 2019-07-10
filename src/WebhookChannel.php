<?php

namespace NotificationChannels\Webhook;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\ClientInterface;

use Illuminate\Support\Arr;
use Illuminate\Notifications\Notification;

use NotificationChannels\Webhook\Exceptions\CouldNotSendNotification;

class WebhookChannel
{
    /**
     * @var GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * @param GuzzleHttp\ClientInterface
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return void
     *
     * @throws \NotificationChannels\Webhook\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        foreach ($this->getUrlsForNotifiable($notifiable) as $url) {
            $this->sendWebhookNotification($notifiable, $notification, $url);
        }
    }

    /**
     * Send the notification to a single webhook
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return void
     *
     * @throws \NotificationChannels\Webhook\Exceptions\CouldNotSendNotification
     */
    protected function sendWebhookNotification($notifiable, Notification $notification, string $url)
    {
        $webhookData = $notification->toWebhook($notifiable)->toArray();

        [ 'data' => $data, 'headers' => $headers ] = $webhookData;

        try {
            $response = $this->client->post($url, [
                'body'      => json_encode($data),
                'verify'    => false,
                'headers'   => $headers 
            ]);
        } catch (RequestException $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception->getResponse());
        }
    }

    /**
     * @param mixed $notifiable
     */
    protected function getUrlsForNotifiable($notifiable)
    {
        return Arr::wrap($notifiable->routeNotificationFor('Webhook'));
    }
}
