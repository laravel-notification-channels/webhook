<?php

namespace NotificationChannels\Webhook\Exceptions;

use GuzzleHttp\Psr7\Response;

class CouldNotSendNotification extends \Exception
{
    private $response;

    /**
     * CouldNotSendNotification constructor.
     * @param Response $response
     * @param string $message
     * @param int|null $code
     */
    public function __construct(Response $response, string $message, int $code = null)
    {
        $this->response = $response;
        $this->message = $message;
        $this->code = $code ?? $response->getStatusCode();

        parent::__construct($message, $code);
    }

    /**
     * @param Response $response
     * @return CouldNotSendNotification
     */
    public static function serviceRespondedWithAnError(Response $response)
    {
        return new self(
            $response,
            sprintf('Webhook responded with an error: `%s`', $response->getBody()->getContents())
        );
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
