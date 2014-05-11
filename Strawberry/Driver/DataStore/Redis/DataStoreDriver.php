<?php
namespace Strawberry\Driver\DataStore\Redis;


use Predis\Client;
use Strawberry\Driver\DataStore\AbstractDataStoreDriver;

class DataStoreDriver extends AbstractDataStoreDriver {

    /** @var Client */
    private $client = null;

    /**
     * @param bool $forceNew
     * @return Client
     */
    private function getClient($forceNew = false)
    {
        if (true === $forceNew || null === $this->client) {
            $connectionConfigArr = $this->getConfigProvider()->getDataStoreConfig()->getNode('connection')->getAsArray();
            $this->getLogger()->debug('Creating Redis connection.');
            $this->client = new Client($connectionConfigArr);
        }

        return $this->client;
    }

    /**
     * Store value in given key.
     *
     * @param string $key for stored value with namespace ex.: 'data\namespace\key'
     * @param mixed $value stored value
     * @return bool
     */
    public function set($key, $value)
    {
        // TODO: Implement set() method.
    }

    /**
     * Get value from store.
     *
     * @param $key for stored value with namespace ex.: 'data\namespace\key'
     * @return mixed|null NULL value when key doesn't exists
     */
    public function get($key)
    {
        // TODO: Implement get() method.
    }


} 