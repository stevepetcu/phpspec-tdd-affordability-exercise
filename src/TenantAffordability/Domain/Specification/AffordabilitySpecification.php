<?php declare(strict_types=1);

namespace GoodLord\TenantAffordability\Domain\Specification;

use GoodLord\TenantAffordability\Domain\Entity\Property;
use GoodLord\TenantAffordability\Domain\Entity\Tenant;

class AffordabilitySpecification
{
    public function isSatisfiedBy(Tenant $tenant, Property $property): bool
    {
        return $tenant->getAffordabilityScore() >= $property->getPcm();
    }
}
