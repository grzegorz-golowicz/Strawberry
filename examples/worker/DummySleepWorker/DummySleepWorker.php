<?php

namespace examples\worker\DummySleepWorker;


use Strawberry\Driver\MQ\AbstractWorker;
use Strawberry\Driver\MQ\Message;

class DummySleepWorker extends AbstractWorker{
    /**
     * @param Message $message
     * @return bool
     */
    public function processMessage(Message $message)
    {
        echo $this->getName() . ":\n";
        echo 'Message ID:' . $message->getMessageId() . "\n";
        sleep(2);
        echo "Message release... \n";

        return true;
    }

    /**
     * @return bool
     */
    public function isLastJobSuccessful()
    {
        return true;
    }

    public function getName()
    {
        return 'DummySleepWorker';
    }
} 