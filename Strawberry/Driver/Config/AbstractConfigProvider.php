<?php

namespace Strawberry\Driver\Config;

/**
 * Class AbstractConfigProvider
 * Base class for all ConfigProviders excepts LocalConfigProvider that is Initial Config Provider
 * @package Strawberry\Driver\Config
 */
abstract class AbstractConfigProvider
{

    const PATH_MQ = 'MQ';

    const PATH_WORKERS = 'WORKERS';

    private $uri;

    private $prefix;

    private $username;

    private $password;

    function __construct($uri, $prefix = null, $username = null, $password = null)
    {

    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $prefix
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * @return mixed
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param mixed $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return ConfigEntity
     */
    abstract public function getMQConfig();

    /**
     * @param string $workerName
     * @return ConfigEntity
     */
    abstract public function getWorkerConfig($workerName);
} 