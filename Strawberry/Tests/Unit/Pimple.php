<?php
require_once(realpath('../../') . '/vendor/autoload.php');
require_once(realpath('../../') . '/Autoloader.php');
$container = new \Pimple();

/** @var \Psr\Log\LoggerInterface */
$container['logger'] = $container->share(function ($c) {
    $logger = new \Monolog\Logger('test_logger');
    $logger->pushHandler(new \Monolog\Handler\TestHandler());
    return $logger;
});

Strawberry\Registry::setDependencyContainer($container);