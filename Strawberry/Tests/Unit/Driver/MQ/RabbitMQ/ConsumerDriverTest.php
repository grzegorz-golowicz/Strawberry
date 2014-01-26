<?php

class ConsumerDriverTest extends PHPUnit_Framework_TestCase
{

    public function testWorkerWithoutWorkerInstance()
    {
        $this->setExpectedException('Strawberry\Exception\NullWorkerException');
        $consumer = new \Strawberry\Driver\MQ\RabbitMQ\ConsumerDriver();
        $consumer->setLogger(Strawberry\Registry::getDependencyContainer()['logger']);
        $consumer->run();
    }
}
 