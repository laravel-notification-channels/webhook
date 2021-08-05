<?php


namespace NotificationChannels\Webhook\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WebhookNotificationSentEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $response;

    public function __construct(array $response)
    {
        $this->response = $response;
    }
}
