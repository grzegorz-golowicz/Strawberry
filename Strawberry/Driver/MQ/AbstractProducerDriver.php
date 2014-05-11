<?php
namespace Strawberry\Driver\MQ;


use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Strawberry\Driver\Config\AbstractConfigProvider;

abstract class AbstractProducerDriver implements LoggerAwareInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /** @var  AbstractConfigProvider */
    private $configProvider;

    public function __construct(AbstractConfigProvider $configProvider)
    {
        $this->configProvider = $configProvider;
    }

    /**
     * @return AbstractConfigProvider
     */
    public function getConfigProvider()
    {
        return $this->configProvider;
    }

    /**
     * Sets a logger instance on the object
     *
     * @param LoggerInterface $logger
     * @return null
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return LoggerInterface
     */
    protected function getLogger()
    {
        return $this->logger;

    }

    /**
     * @param string $workerName
     * @param Message $msg
     * @return string|NULL
     */
    abstract public function publishMessage($workerName, Message $msg);

}