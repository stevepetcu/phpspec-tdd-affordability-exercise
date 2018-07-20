<?php declare(strict_types=1);

namespace GoodLord\TenantAffordability\Infrastructure\Factory;

use AppendIterator;
use DirectoryIterator;

class ConfigurationFactory
{
    public function create(array $configurationPaths): array
    {
        $configDirectories = $this->getConfigDirectoriesIterator($configurationPaths);

        $settings = [];

        /** @var DirectoryIterator $filename */
        foreach ($configDirectories as $filename) {
            if ($filename->isFile()) {
                $settings = array_replace_recursive($settings, require $filename->getRealPath());
            }
        }

        return $settings;
    }

    private function getConfigDirectoriesIterator(array $configurationPaths): AppendIterator
    {
        $configDirectories = new AppendIterator();

        foreach ($configurationPaths as $path) {
            $configDirectories->append(new DirectoryIterator($path));
        }

        return $configDirectories;
    }
}
