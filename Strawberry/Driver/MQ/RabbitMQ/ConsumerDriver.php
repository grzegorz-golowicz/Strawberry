<?php
namespace Strawberry\Driver\MQ;

use PhpAmqpLib\Connection\AMQPConnection;
use Strawberry\Driver\MQ\RabbitMQ\MessageTranslator;

class RabbitMQConsumerDriver extends \Strawberry\Driver\MQ\AbstractConsumerDriver
{
    /** @var AMQPConnection */
    protected $connection = null;

    /**
     * @param bool $forceNew set true if you want new connection instead of reusing.
     * @return AMQPConnection
     */
    protected function getConnection($forceNew = false)
    {
        if (true === $forceNew || null === $this->connection) {
            $this->connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
        }

        return $this->connection;
    }

    /**
     * @return \PhpAmqpLib\Channel\AMQPChannel
     */
    protected function getChannel()
    {
        return $this->getConnection()->channel();
    }

    protected function runWorker()
    {
        $this->getChannel()->queue_declare('simple_queue', false, true, false, false);

        $callback = function (\PhpAmqpLib\Message\AMQPMessage $msg) {
            $this->getWorkerInstance()->processMessage($this->translateMessage($msg)); //FIXME pass translated msg in params

            if ($this->getWorkerInstance()->isLastJobSuccessful()) {
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
            } else {
                $msg->delivery_info['channel']->basic_cancel($msg->delivery_info['delivery_tag']);
            }
        };

        $this->getChannel()->basic_qos(null, 1, null);
        $this->getChannel()->basic_consume('simple_queue', '', false, false, false, false, $callback);

        while (count($this->getChannel()->callbacks)) {
            $this->getChannel()->wait();
        }

        $this->getChannel()->close();
        $this->getConnection()->close();
    }

    protected function translateMessage(\PhpAmqpLib\Message\AMQPMessage $msg)
    {
        return MessageTranslator::translator($msg);
    }
}