<?php declare(strict_types=1);

namespace GoodLord\TenantAffordability\Domain\Calculator;

use Litipk\BigNumbers\Decimal;

class AffordabilityScoreCalculator
{
    private const MONTHLY_NET_INCOME_MULTIPLIER = 1.25;

    public function affordabilityScore(array $accountSummary): Decimal
    {
        $monthCount = count($accountSummary);

        if ($monthCount < 1) {
            throw new \InvalidArgumentException("Account summary should contain at least 1 month.");
        }

        $result = Decimal::create(0, 3);
        $monthCount = Decimal::create($monthCount);

        foreach ($accountSummary as $month => $summary) {
            /** @var Decimal $income */
            $income = $summary['income'];
            /** @var Decimal $expenses */
            $expenses = $summary['expenses'];

            $result = $result->add($income->sub($expenses));
        }

        return $result
            ->div(Decimal::create($monthCount))
            ->mul(Decimal::create(self::MONTHLY_NET_INCOME_MULTIPLIER));
    }
}
