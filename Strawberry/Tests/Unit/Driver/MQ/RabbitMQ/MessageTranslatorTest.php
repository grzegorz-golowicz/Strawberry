<?php
use PhpAmqpLib\Message\AMQPMessage;
use Strawberry\Driver\MQ\RabbitMQ\MessageTranslator;

class MessageTranslatorTest extends PHPUnit_Framework_TestCase
{

    public function testMqToMessageIfResponseIsMessage()
    {
        $msg = new \Strawberry\Driver\MQ\Message();

        $msgMq = new AMQPMessage();
        $msgMq->body = serialize($msg);

        $res = MessageTranslator::mqToMessage($msgMq);
        $this->assertInstanceOf('Strawberry\Driver\MQ\Message', $res);
    }

}
 