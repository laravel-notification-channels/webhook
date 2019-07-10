<?php

namespace NotificationChannels\Webhook\Test;

use Mockery;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * Hook into the testing framework.
     */
    public function tearDown() : void
    {
        if ($container = Mockery::getContainer()) {
            $this->addToAssertionCount($container->mockery_getExpectationCount());
        }

        Mockery::close();
        parent::tearDown();
    }
}
