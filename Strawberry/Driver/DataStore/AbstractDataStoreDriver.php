<?php
namespace Strawberry\Driver\DataStore;


use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Strawberry\Driver\Config\AbstractConfigProvider;

abstract class AbstractDataStoreDriver implements LoggerAwareInterface
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
     * Store value in given key.
     *
     * @param string $key for stored value with namespace ex.: 'data\namespace\key'
     * @param mixed $value stored value
     * @return bool
     */
    abstract public function set($key, $value);

    /**
     * Get value from store.
     *
     * @param $key for stored value with namespace ex.: 'data\namespace\key'
     * @return mixed|null NULL value when key doesn't exists
     */
    abstract public function get($key);

}