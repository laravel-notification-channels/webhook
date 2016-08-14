<?php

namespace NotificationChannels\Webhook\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($response)
    {
        return new static('Webhook responded with an error: `'.$response->getBody()->getContents().'`');
    }
}
