<?php

use GoodLord\TenantAffordability\Infrastructure\Factory\ConfigurationFactory;
use GoodLord\TenantAffordability\Infrastructure\Factory\ContainerFactory;

$environment = getenv('APPLICATION_ENV') ?: ENV_PRODUCTION;

$configurationPaths = [
    PATH_CONFIG . '/common',
    PATH_CONFIG . "/$environment",
];

$configurationFactory = new ConfigurationFactory();
$containerFactory = new ContainerFactory();

$configuration = $configurationFactory->create($configurationPaths);
$providers = require PATH_CONFIG . '/providers.php';

return $containerFactory->create($configuration, $providers);
