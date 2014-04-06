<?php
namespace Strawberry\Driver\MQ;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Strawberry\Driver\Config\ConfigEntity;

abstract class AbstractWorker implements LoggerAwareInterface
{
    /** @var  LoggerInterface */
    private $logger;

    /** @var  ConfigEntity */
    private $config;

    /**
     * @param \Strawberry\Driver\Config\ConfigEntity $config
     */
    public function setConfig(ConfigEntity $config)
    {
        $this->config = $config;
    }

    /**
     * @return \Strawberry\Driver\Config\ConfigEntity
     */
    public function getConfig()
    {
        return $this->config;
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
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param Message $message
     * @return bool
     */
    public abstract function processMessage(Message $message);

    /**
     * @return bool
     */
    public abstract function isLastJobSuccessful();

    /**
     * Worker name ex.: DownloadWorker
     * @return string
     */
    public abstract function getName();
} 