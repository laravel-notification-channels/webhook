<?php

namespace NotificationChannels\Webhook\Test;

use DateTime;
use Illuminate\Support\Arr;
use NotificationChannels\Webhook\WebhookMessage;

class MessageTest extends \PHPUnit_Framework_TestCase
{
    /** @var \NotificationChannels\Webhook\WebhookMessage */
    protected $message;

    public function setUp()
    {
        parent::setUp();
        $this->message = new WebhookMessage();
    }

    /** @test */
    public function it_accepts_data_when_constructing_a_message()
    {
        $message = new WebhookMessage(['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], Arr::get($message->toArray(), 'data'));
    }

    /** @test */
    public function it_provides_a_create_method()
    {
        $message = WebhookMessage::create(['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], Arr::get($message->toArray(), 'data'));
    }

    /** @test */
    public function it_can_set_the_webhook_data()
    {
        $this->message->data(['foo' => 'bar']);
        $this->assertEquals(['foo' => 'bar'], Arr::get($this->message->toArray(), 'data'));
    }

    /** @test */
    public function it_can_set_the_user_agent()
    {
        $this->message->userAgent('MyUserAgent');
        $this->assertEquals('MyUserAgent', Arr::get($this->message->toArray(), 'headers.User-Agent'));
    }

    /** @test */
    public function it_can_set_a_custom_header()
    {
        $this->message->header('X-Custom', 'Value');
        $this->assertEquals(['X-Custom' => 'Value'], Arr::get($this->message->toArray(), 'headers'));
    }
}
