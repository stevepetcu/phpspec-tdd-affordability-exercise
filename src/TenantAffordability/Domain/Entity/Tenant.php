<?php declare(strict_types=1);

namespace GoodLord\TenantAffordability\Domain\Entity;

use Litipk\BigNumbers\Decimal;

class Tenant
{
    private $name;

    private $address;

    private $bank;

    private $affordabilityScore;

    public function __construct(string $name, string $address, string $bank, Decimal $affordabilityScore)
    {
        $this->name = $name;
        $this->address = $address;
        $this->bank = $bank;
        $this->affordabilityScore = $affordabilityScore;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getBank(): string
    {
        return $this->bank;
    }

    public function getAffordabilityScore(): Decimal
    {
        return $this->affordabilityScore;
    }
}
