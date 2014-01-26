<?php
namespace Strawberry\Driver\MQ;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

abstract class AbstractWorker implements LoggerAwareInterface
{
    private $logger;

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
} 