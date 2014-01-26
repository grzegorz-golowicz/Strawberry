<?php
namespace Strawberry\Driver\MQ;

use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Strawberry\Exception\NullWorkerException;

abstract class AbstractConsumerDriver implements LoggerAwareInterface
{ //FIXME LoggerAwareInterface

    /** @var WorkerInterface */
    protected $workerInstance = null;

    /**
     * @var LoggerInterface
     */
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
     * @param WorkerInterface $workerInstance
     */
    public function setWorkerInstance(WorkerInterface $workerInstance)
    {
        $this->getLogger()->debug('Setting worker (' . get_class($this->getWorkerInstance()) . ').');

        $this->workerInstance = $workerInstance;
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