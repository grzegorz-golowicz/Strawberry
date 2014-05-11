<?php
$c = array();
$c['dummy'] = array();
$c['dummy']['MQ'] = array();
$c['dummy']['MQ']['driver'] = 'RabbitMQ';
$c['dummy']['MQ']['connection'] = array();
$c['dummy']['MQ']['connection']['host'] = 'localhost';
$c['dummy']['MQ']['connection']['port'] = 5672;
$c['dummy']['MQ']['connection']['user'] = 'guest';
$c['dummy']['MQ']['connection']['password'] = 'guest';
$c['dummy']['WORKERS'] = array();
$c['dummy']['WORKERS']['DummySleepWorker'] = array();
$c['dummy']['WORKERS']['DummySleepWorker']['queueName'] = 'dummy';
$c['dummy']['DATA_STORAGE'] = array();
$c['dummy']['DATA_STORAGE']['driver'] = 'Redis';
$c['dummy']['DATA_STORAGE']['connection'] = array();
$c['dummy']['DATA_STORAGE']['connection']['host'] = 'localhost';
$c['dummy']['DATA_STORAGE']['connection']['port'] = 6379;
$c['dummy']['DATA_STORAGE']['connection']['scheme'] = 'tcp';

echo json_encode($c);