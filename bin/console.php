#!/usr/bin/env php
<?php

use Symfony\Component\Console\Application;

require_once __DIR__ . '/../bootstrap/constants.php';
require_once PATH_ROOT . '/vendor/autoload.php';

/** @var Application $console */
$console = require PATH_ROOT . '/bootstrap/console.php';

$console->run();
