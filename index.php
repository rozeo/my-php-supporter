<?php

use Rozeo\Support\SessionHandler\SessionHandlerFactory;

require_once './vendor/autoload.php';

$di = new \Rozeo\Support\DIContainer();

$di->bind('string', function () {
    return 'abc';
});

$di->bind(\Rozeo\Support\Sample\TestClassInterface::class, \Rozeo\Support\Sample\TestClass::class);

$class = $di->resolve(\Rozeo\Support\Sample\TestClassInterface::class);
var_dump($class);