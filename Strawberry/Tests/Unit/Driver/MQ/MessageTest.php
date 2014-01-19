<?php
use Strawberry\Driver\MQ\Message;

class MessageTest extends PHPUnit_Framework_TestCase
{

    const SETGET_TEST_VALUE = 'test';

    public function testMessageIdSetGet()
    {
        $msg = new Message();
        $msg->setMessageId(self::SETGET_TEST_VALUE);
        $this->assertEquals(self::SETGET_TEST_VALUE, $msg->getMessageId());
    }

    public function testPayloadSetGet()
    {
        $msg = new Message();
        $msg->setPayload(self::SETGET_TEST_VALUE);
        $this->assertEquals(self::SETGET_TEST_VALUE, $msg->getPayload());
    }

}
 