<?php declare(strict_types=1);

namespace GoodLord\TenantAffordability\Infrastructure\Provider;

use DI\Definition\Source\DefinitionArray;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;

/**
 * Provides the DI Container with the definition for the CLI Application.
 */
class ConsoleProvider extends DefinitionArray
{
    public function __construct()
    {
        $definitions = [
            Application::class => function (ContainerInterface $container) {
                $application = new Application(
                    (string)$container->get('application.name'),
                    (string)$container->get('application.version')
                );

                return $application;
            },
        ];

        parent::__construct($definitions);
    }
}
