<?php declare(strict_types=1);

namespace GoodLord\TenantAffordability\Domain\Builder;

use GoodLord\TenantAffordability\Domain\Entity\Property;
use Litipk\BigNumbers\Decimal;

class PropertyBuilder
{
    public function property(array $propertyData)
    {
        if (!isset($propertyData['Id'], $propertyData['Address'], $propertyData['Price (pcm)'])) {
            throw new \InvalidArgumentException('Wrong or incomplete property data.');
        }

        return new Property(
            (int)$propertyData['Id'],
            $propertyData['Address'],
            Decimal::create($propertyData['Price (pcm)'])
        );
    }
}
