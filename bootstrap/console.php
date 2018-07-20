<?php

use GoodLord\TenantAffordability\Presentation\Cli\Action\CreateAffordabilityMatchAction;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;

/** @var ContainerInterface $container */
$container = require PATH_ROOT . '/bootstrap/container.php';
$console = $container->get(Application::class);

$commands = [
    $container->get(CreateAffordabilityMatchAction::class),
];

$console->addCommands($commands);

return $console;
