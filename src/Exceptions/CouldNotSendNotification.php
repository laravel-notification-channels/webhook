<?php

namespace NotificationChannels\Webhook\Exceptions;

use Psr\Http\Message\ResponseInterface as Response;
use Exception;

class CouldNotSendNotification extends Exception
{
    /**
     * @const string
     */
    private const ERROR_STRING = 'Webhook responded with an error: %s';

    /**
     * @param Psr\Http\Message\ResponseInterface $response
     */
    public static function serviceRespondedWithAnError(Response $response)
    {
        return new static(sprintf(self::ERROR_STRING, (string) $response->getBody()->getContents()));
    }
}
