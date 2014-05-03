<?php
namespace Strawberry\Driver\MQ\RabbitMQ;

use PhpAmqpLib\Connection\AMQPConnection;
use Strawberry\Driver\Config\AbstractConfigProvider;
use Strawberry\Driver\Config\ConfigEntity;
use Strawberry\Driver\MQ\AbstractConsumerDriver;
use Strawberry\Driver\MQ\RabbitMQ\MessageTranslator;

class ConsumerDriver extends AbstractConsumerDriver
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

    protected function runWorker()
    {
        $workerConfig = $this->getConfigProvider()->getWorkerConfig($this->getWorkerInstance()->getName());
        $channel = $this->getNewChannel();
        $channel->queue_declare($workerConfig->getValue('queueName'), false, true, false, false);

        $callback = function (\PhpAmqpLib\Message\AMQPMessage $msg) {
            $this->getLogger()->debug('Running processMessage for: ' . $msg->delivery_info['delivery_tag']);

            try {
                $this->getWorkerInstance()->processMessage($this->translateMessage($msg));

                if ($this->getWorkerInstance()->isLastJobSuccessful()) {
                    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
                    $this->getLogger()->debug('Sending ACK for message: ' . $msg->delivery_info['delivery_tag']);
                } else {
                    $msg->delivery_info['channel']->basic_cancel($msg->delivery_info['delivery_tag']);
                    $this->getLogger()->warning('Canceling message: ' . $msg->delivery_info['delivery_tag']);
                }
            } catch (\Exception $ex) {
                $this->getLogger()->critical($ex->getMessage());
            }



        };

        $channel->basic_qos(null, 1, null);
        $channel->basic_consume($workerConfig->getValue('queueName'), '', false, false, false, false, $callback);

        $this->getLogger()->debug('Waiting for queue: ' . $workerConfig->getValue('queueName'));

        while (count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $this->getLogger()->debug('Channel closed.');
        $this->getConnection()->close();
        $this->getLogger()->debug('Connection closed.');
    }

    protected function translateMessage(\PhpAmqpLib\Message\AMQPMessage $msg)
    {
        return MessageTranslator::mqToMessage($msg);
    }
}