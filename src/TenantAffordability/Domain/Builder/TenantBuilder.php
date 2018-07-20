<?php declare(strict_types=1);

namespace GoodLord\TenantAffordability\Domain\Builder;

use GoodLord\TenantAffordability\Domain\Calculator\AffordabilityScoreCalculator;
use GoodLord\TenantAffordability\Domain\Entity\BankStatement;
use GoodLord\TenantAffordability\Domain\Entity\Tenant;

class TenantBuilder
{
    private $affordabilityScoreCalculator;

    public function __construct(
        AffordabilityScoreCalculator $affordabilityScoreCalculator
    ) {
        $this->affordabilityScoreCalculator = $affordabilityScoreCalculator;
    }

    public function tenant(BankStatement $bankStatement): Tenant
    {
        return new Tenant(
            $bankStatement->getTenantName(),
            $bankStatement->getTenantAddress(),
            $bankStatement->getBankName(),
            $this->affordabilityScoreCalculator->affordabilityScore($bankStatement->getAccountSummary())
        );
    }
}
