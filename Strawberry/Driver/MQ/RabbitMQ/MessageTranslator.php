<?php
namespace Strawberry\Driver\MQ\RabbitMQ;

use PhpAmqpLib\Message\AMQPMessage;
use Strawberry\Driver\MQ\Message;

class MessageTranslator
{
    /**
     * @param AMQPMessage $message
     * @throws \Exception
     * @return Message|null
     */
    public static function mqToMessage(AMQPMessage $message)
    {
        $payload = unserialize($message->body);
        if (!($payload instanceof \Strawberry\Driver\MQ\Message)) {
            throw new \InvalidArgumentException('Payload should be instance of Strawberry\Driver\MQ\Message!');
        }

        return $payload;
    }
} 