<?php
namespace Strawberry\Driver\Config\JSON;


use Strawberry\Driver\Config\ConfigurationNotProvidedException;
use Strawberry\Driver\Config\AbstractConfigProvider;
use Strawberry\Driver\Config\ConfigEntity;

class ConfigProvider extends AbstractConfigProvider
{

    /**
     * @var array;
     */
    private $configCache;

    function __construct($uri, $prefix = null, $username = null, $password = null)
    {
        parent::__construct($uri, $prefix, $username, $password);

        $rawJSON = file_get_contents($uri);
        $rawConfig = json_decode($rawJSON, true);

        if (null === $prefix || empty($prefix)) {
            $this->configCache = $rawConfig;
        } elseif (isset($rawConfig[$prefix]) && is_array($rawConfig[$prefix])) {
            $this->configCache = $rawConfig[$prefix];
        } else {
            throw new \InvalidArgumentException('Wrong or not existing configuration prefix (' . $prefix . ')');
        }
    }


    /**
     * @throws ConfigurationNotProvidedException
     * @return ConfigEntity
     */
    public function getMQConfig()
    {
        if (isset($this->configCache[self::PATH_MQ]) && is_array($this->configCache[self::PATH_MQ])) {
            return new ConfigEntity($this->configCache[self::PATH_MQ]);
        } else {
            throw new ConfigurationNotProvidedException('Configuration for Message Queue not provided!');
        }
    }

    /**
     * @param string $workerName
     * @throws ConfigurationNotProvidedException
     * @return ConfigEntity
     */
    public function getWorkerConfig($workerName)
    {
        if (isset($this->configCache[self::PATH_WORKERS][$workerName]) && is_array($this->configCache[self::PATH_WORKERS][$workerName])) {
            return new ConfigEntity($this->configCache[self::PATH_WORKERS][$workerName]);
        } else {
            throw new ConfigurationNotProvidedException('Configuration for Worker (' . $workerName . ') not provided!');
        }
    }


} 