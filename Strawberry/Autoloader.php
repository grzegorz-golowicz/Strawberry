<?php
namespace Strawberry;


class Autoloader
{

    /**
     * @param string $class
     */
    public function __autoload($class)
    {
        require_once($this->classNameToFileName($class));
    }

    public function register()
    {
        spl_autoload_register(array($this, '__autoload'));
    }

    /**
     * Ugly way to find absolute path of class file.
     *
     * @param string $class
     * @return string
     */
    private function classNameToFileName($class) //TODO Refactor
    {
        $filename = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
        return realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR . $filename;
    }
}