<?php

namespace NotificationChannels\Webhook\Test;

use Illuminate\Support\Arr;
use NotificationChannels\Webhook\WebhookMessage;
use Orchestra\Testbench\TestCase;

class MessageTest extends TestCase
{
    /** @var \NotificationChannels\Webhook\WebhookMessage */
    protected $message;

    public function setUp(): void
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
    public function it_can_set_the_webhook_query()
    {
        $this->message->query(['foo' => 'bar']);
        $this->assertEquals(['foo' => 'bar'], Arr::get($this->message->toArray(), 'query'));
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

    /** @test */
    public function it_can_verify_the_request()
    {
        $this->message->verify();
        $this->assertEquals(true, Arr::get($this->message->toArray(), 'verify'));
    }

    /** @test */
    public function it_can_add_request_options()
    {
        $this->message->http(['timeout' => 3.14]);
        $this->assertEquals(3.14, Arr::get($this->message->toArray(), 'http.timeout'));
    }
}
