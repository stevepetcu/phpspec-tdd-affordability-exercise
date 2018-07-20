<?php declare(strict_types=1);

namespace GoodLord\TenantAffordability\Infrastructure\Provider;

use DI\Definition\Source\DefinitionArray;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class LoggerProvider extends DefinitionArray
{
    public function __construct()
    {
        $definitions = [
            LoggerInterface::class => function (ContainerInterface $container) {
                $loggerClass = $container->get('logger.class');

                $logger = new $loggerClass('error_logger');

                if ($logger instanceof Logger) {
                    $handler = new StreamHandler($container->get('logs.errors.path'), Logger::ERROR);
                    $logger->pushHandler($handler);
                }

                return $logger;
            },
        ];

        parent::__construct($definitions);
    }
}
