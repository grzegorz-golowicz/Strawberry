<?php
namespace Strawberry\Driver\MQ;

use PhpAmqpLib\Message\AMQPMessage;

abstract class AbstractConsumerDriver
{ //FIXME LoggerAwareInterface

    /** @var WorkerInterface */
    protected $workerInstance = null;

    abstract protected function runWorker();

    /**
     * @return WorkerInterface
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
            throw new \Exception('Cannot run consumer without Worker instance.'); //FIXME change to specific exception
        }

        $this->runWorker();
    }

} 