<?php
namespace Strawberry\Driver\MQ;

interface WorkerInterface
{
    /**
     * @param Message $message
     * @return bool
     */
    public function processMessage(Message $message);

    /**
     * @return bool
     */
    public function isLastJobSuccessful();
} 