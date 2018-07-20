<?php declare(strict_types=1);

namespace GoodLord\TenantAffordability\Application\Service;

use GoodLord\TenantAffordability\Domain\Builder\BankStatementBuilder;
use GoodLord\TenantAffordability\Domain\Builder\PropertyBuilder;
use GoodLord\TenantAffordability\Domain\Builder\TenantBuilder;
use GoodLord\TenantAffordability\Domain\Csv\BankCsvReader;
use GoodLord\TenantAffordability\Domain\Specification\AffordabilitySpecification;
use GoodLord\TenantAffordability\Infrastructure\Csv\CsvReader;

class AffordabilityCheckService
{
    private $propertyBuilder;

    private $tenantBuilder;

    private $affordabilitySpecification;

    public function __construct(
        PropertyBuilder $propertyBuilder,
        TenantBuilder $tenantBuilder,
        AffordabilitySpecification $affordabilitySpecification
    ) {
        $this->propertyBuilder = $propertyBuilder;
        $this->tenantBuilder = $tenantBuilder;
        $this->affordabilitySpecification = $affordabilitySpecification;
    }

    public function affordabilityCheck(string $bankStatementFilePath, string $propertyListFilePath): array
    {
        $bankStatement = (new BankStatementBuilder(new BankCsvReader($bankStatementFilePath)))->bankStatement();
        $tenant = $this->tenantBuilder->tenant($bankStatement);

        $results = [];

        $propertyListReader = new CsvReader($propertyListFilePath);

        foreach ($propertyListReader->read() as $propertyData) {
            $property = $this->propertyBuilder->property($propertyData);

            $results[$property->getId()]['address'] = $property->getAddress();
            $results[$property->getId()]['affordable'] =
                $this->affordabilitySpecification->isSatisfiedBy($tenant, $property)
                    ? 'YES'
                    : 'NO';
        }

        return $results;
    }
}
