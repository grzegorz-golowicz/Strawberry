<?php
namespace Strawberry;


class Registry
{
    /** @var \Pimple */
    private static $dependencyContainer = null;

    /**
     * @param \Pimple $dependencyContainer
     */
    public static function setDependencyContainer(\Pimple $dependencyContainer)
    {
        self::$dependencyContainer = $dependencyContainer;
    }

    /**
     * @return \Pimple
     * @throws \UnexpectedValueException
     */
    public static function getDependencyContainer()
    {
        if (null === self::$dependencyContainer) {
            throw new \UnexpectedValueException('Dependency container not set!');
        }
        return self::$dependencyContainer;
    }
} 