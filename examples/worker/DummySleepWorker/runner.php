<?php
require_once('../../../Strawberry/vendor/autoload.php');
require_once('../../../Strawberry/Autoloader.php');

$autoloader = new \Strawberry\Autoloader();
$autoloader->register();

require_once('DummySleepWorker.php');

$configProvider = new \Strawberry\Driver\Config\JSON\ConfigProvider('config.json', 'dummy');

$logger = new \Monolog\Logger('console');
$logger->pushHandler(new \Monolog\Handler\StreamHandler('php://stdout'));

$worker = new \examples\worker\DummySleepWorker\DummySleepWorker();
$consumerDriver = new \Strawberry\Driver\MQ\RabbitMQ\ConsumerDriver($configProvider);
$consumerDriver->setLogger($logger);
$consumerDriver->setWorkerInstance($worker);
$consumerDriver->run();