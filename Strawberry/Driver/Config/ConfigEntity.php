<?php
namespace Strawberry\Driver\Config;

class ConfigEntity
{

    private $config = array();

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param $key
     * @throws \InvalidArgumentException
     * @return ConfigEntity
     */
    public function getNode($key)
    {
        if (!isset($this->config[$key])) {
            throw new \InvalidArgumentException('Trying to get not existing config node (' . $key . ')');
        } elseif (!is_array($this->config[$key])) {
            throw new \InvalidArgumentException('Trying to get config value as config node (' . $key . ')');
        }

        return new ConfigEntity($this->config[$key]);
    }

    public function getValue($key)
    {
        if (!isset($this->config[$key])) {
            throw new \InvalidArgumentException('Trying to get not existing config value (' . $key . ')');
        } elseif (is_array($this->config[$key])) {
            throw new \InvalidArgumentException('Trying to get config node as config value (' . $key . ')');
        }

        return $this->config[$key];
    }

    public function getAsArray()
    {
        return $this->config;
    }
} 