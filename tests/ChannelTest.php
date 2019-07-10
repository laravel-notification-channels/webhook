<?php

namespace NotificationChannels\Webhook\Test;

use Mockery;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Notifications\Notification;
use NotificationChannels\Webhook\WebhookChannel;
use NotificationChannels\Webhook\WebhookMessage;
use NotificationChannels\Webhook\Exceptions\CouldNotSendNotification;

class ChannelTest extends TestCase
{
    /** @test */
    public function it_can_send_a_notification()
    {
        $client = $this->createTestClient(200);
        $channel = new WebhookChannel($client);
        $channel->send(new TestNotifiable(), new TestNotification());
    }

    /** @test */
    public function it_can_send_a_notification_with_2xx_status()
    {
        $client = $this->createTestClient(201);

        $channel = new WebhookChannel($client);
        $channel->send(new TestNotifiable(), new TestNotification());
    }

    /**
     * @test
     */
    public function it_throws_an_exception_when_it_could_not_send_the_notification()
    {
        $this->expectException(CouldNotSendNotification::class);

        $mock = new MockHandler([
                new RequestException('Server Error',
                new Request('POST', 'test'),
                new Response(500, [], 'Server Error')
            ),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $channel = new WebhookChannel($client);
        $channel->send(new TestNotifiable(), new TestNotification());
    }

    /**
     * @param int
     */
    private function createTestClient(int $statusCode = 200)
    {
        $response = new Response(201);

        $testPayload = [
            'body' => '{"payload":{"webhook":"data"}}',
            'headers' => [
                'User-Agent' => 'WebhookAgent',
                'X-Custom' => 'CustomHeader',
            ],
        ];

        $client = Mockery::mock(ClientInterface::class);
        $client->shouldReceive('post')
            ->once()
            ->with('https://notifiable-webhook-url.com', $testPayload)
            ->andReturn($response);

        return $client;
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
