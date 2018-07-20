<?php

if (!defined('PATH_ROOT')) {
    define('PATH_ROOT', __DIR__ . '/..');
}

if (!defined('PATH_SRC')) {
    define('PATH_SRC', PATH_ROOT . '/src');
}

if (!defined('PATH_CONFIG')) {
    define('PATH_CONFIG', PATH_ROOT . '/config');
}

if (!defined('ENV_PRODUCTION')) {
    define('ENV_PRODUCTION', 'production');
}

if (!defined('ENV_DOCKER')) {
    define('ENV_DOCKER', 'docker');
}

if (!defined('ENV_TESTING')) {
    define('ENV_TESTING', 'testing');
}
