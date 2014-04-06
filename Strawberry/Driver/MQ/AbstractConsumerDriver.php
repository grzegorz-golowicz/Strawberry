<?php
namespace Strawberry\Driver\MQ;

use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Strawberry\Driver\Config\AbstractConfigProvider;
use Strawberry\Exception\NullWorkerException;

/**
 * Class AbstractConsumerDriver
 * Base class for all PHP Workers
 * @package Strawberry\Driver\MQ
 */
abstract class AbstractConsumerDriver implements LoggerAwareInterface
{
    /** @var WorkerInterface */
    protected $workerInstance = null;

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
    protected function getConfigProvider()
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

    abstract protected function runWorker();

    /**
     * @return AbstractWorker
     */
    protected function getWorkerInstance()
    {
        return $this->workerInstance;
    }

    /**
     * @param AbstractWorker $worker
     */
    public function setWorkerInstance(AbstractWorker $worker)
    {
        $this->getLogger()->debug('Setting worker (' . get_class($worker) . ').');

        $worker->setConfig($this->getConfigProvider()->getWorkerConfig($worker->getName()));

        $this->workerInstance = $worker;
    }

    /**
     * @param AMQPMessage $msg
     * @return Message
     */
    abstract protected function translateMessage(AMQPMessage $msg);

    public function run()
    {
        if (null === $this->getWorkerInstance()) {
            $this->getLogger()->critical('Trying to run consumer without Worker instance.');
            throw new NullWorkerException('Cannot run consumer without Worker instance.');
        }

        $this->getLogger()->debug('Running worker (' . get_class($this->getWorkerInstance()) . ').');

        $this->runWorker();
    }

} 