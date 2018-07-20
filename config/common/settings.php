<?php

use Monolog\Logger;

return [
    'logger.class' => Logger::class,
    'logs.errors.path' => PATH_ROOT . '/var/logs/errors.txt',
    'application.name' => 'GoodLord Affordability Check CLI',
    'application.version' => '0.1.0',
];
