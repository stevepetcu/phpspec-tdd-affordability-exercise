<?php declare(strict_types=1);

namespace GoodLord\TenantAffordability\Infrastructure\Factory;

use DI\Container;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

class ContainerFactory
{
    public function create(
        array $configuration,
        array $providers = [],
        string $containerClass = Container::class
    ): ContainerInterface {
        $builder = new ContainerBuilder($containerClass);

        $builder->addDefinitions($configuration);

        foreach ($providers as $definition) {
            $builder->addDefinitions($definition);
        }

        return $builder->build();
    }
}
