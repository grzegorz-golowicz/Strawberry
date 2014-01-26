<?php
require_once(realpath('../../') . '/vendor/autoload.php');
require_once(realpath('../../') . '/Autoloader.php');
$a = new \Strawberry\Autoloader();
$a->register();
require_once('Pimple.php');