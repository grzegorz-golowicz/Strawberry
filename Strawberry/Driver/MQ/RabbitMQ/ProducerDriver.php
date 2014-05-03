<?php

namespace Strawberry\Driver\MQ\RabbitMQ;


use Strawberry\Driver\MQ\AbstractProducerDriver;
use Strawberry\Driver\MQ\Message;

class ProducerDriver extends AbstractProducerDriver
{
    /** @var AMQPConnection */
    private $connection = null;

    /**
     * @param bool $forceNew set true if you want new connection instead of reusing.
     * @return AMQPConnection
     */
    protected function getConnection($forceNew = false)
    {
        $connectionConfig = $this->getConfigProvider()->getMQConfig()->getNode('connection');
        if (true === $forceNew || null === $this->connection) {
            $this->getLogger()->debug('Creating new AMQP connection.');
            $this->connection = new AMQPConnection($connectionConfig->getValue('host'), $connectionConfig->getValue('port'), $connectionConfig->getValue('user'), $connectionConfig->getValue('password'));
        }

        return $this->connection;
    }

    /**
     * @return \PhpAmqpLib\Channel\AMQPChannel
     */
    protected function getNewChannel()
    {
        return $this->getConnection()->channel();
    }

    /**
     * @param string $workerName
     * @param Message $msg
     * @return string|NULL
     */
    public function publishMessage($workerName, Message $msg)
    {
        $workerConfig = $this->getConfigProvider()->getWorkerConfig($workerName);
        $channel = $this->getNewChannel();
        $channel->queue_declare($workerConfig->getValue('queueName'), false, true, false, false);

        $msg = MessageTranslator::messageToMq($msg);
        $channel->basic_publish($msg, '', $workerConfig->getValue('queueName'));

        $channel->close();
        $this->getConnection()->close();
    }
} 