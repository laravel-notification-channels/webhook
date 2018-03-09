<?php

namespace NotificationChannels\Webhook\Test;

use Mockery;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Orchestra\Testbench\TestCase;
use Illuminate\Notifications\Notification;
use NotificationChannels\Webhook\WebhookChannel;
use NotificationChannels\Webhook\WebhookMessage;

class ChannelTest extends TestCase
{
    /** @test */
    public function it_can_send_a_notification()
    {
        $response = new Response(200);
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('post')
            ->once()
            ->with('https://notifiable-webhook-url.com',
                [
                    'body' => '{"payload":{"webhook":"data"}}',
                    'verify' => false,
                    'headers' => [
                        'User-Agent' => 'WebhookAgent',
                        'X-Custom' => 'CustomHeader',
                    ],
                ])
            ->andReturn($response);
        $channel = new WebhookChannel($client);
        $channel->send(new TestNotifiable(), new TestNotification());
    }

    /** @test */
    public function it_can_send_a_notification_with_2xx_status()
    {
        $response = new Response(201);
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('post')
            ->once()
            ->with('https://notifiable-webhook-url.com',
                [
                    'body' => '{"payload":{"webhook":"data"}}',
                    'verify' => false,
                    'headers' => [
                        'User-Agent' => 'WebhookAgent',
                        'X-Custom' => 'CustomHeader',
                    ],
                ])
            ->andReturn($response);
        $channel = new WebhookChannel($client);
        $channel->send(new TestNotifiable(), new TestNotification());
    }

    /**
     * @test
     */
    public function it_throws_an_exception_when_it_could_not_send_the_notification()
    {
        $response = new Response(500);
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('post')
            ->once()
            ->with('https://notifiable-webhook-url.com',
                [
                    'body' => '{"payload":{"webhook":"data"}}',
                    'verify' => false,
                    'headers' => [
                        'User-Agent' => 'WebhookAgent',
                        'X-Custom' => 'CustomHeader',
                    ],
                ])
            ->andReturn($response);
        $channel = new WebhookChannel($client);
        $channel->send(new TestNotifiable(), new TestNotification());
    }
}

class TestNotifiable
{
    use \Illuminate\Notifications\Notifiable;

    /**
     * @return int
     */
    public function routeNotificationForWebhook()
    {
        return 'https://notifiable-webhook-url.com';
    }
}

class TestNotification extends Notification
{
    public function toWebhook($notifiable)
    {
        return
            (new WebhookMessage(
                [
                    'payload' => [
                        'webhook' => 'data',
                    ],
                ]
            ))->userAgent('WebhookAgent')
            ->header('X-Custom', 'CustomHeader');
    }
}
