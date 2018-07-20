<?php declare(strict_types=1);

namespace GoodLord\TenantAffordability\Domain\Entity;

class BankStatement
{
    private $tenantName;

    private $tenantAddress = '';

    private $bankName;

    private $accountSummary;

    public function __construct(string $tenantName, string $tenantAddress, string $bankName, array $accountSummary)
    {
        $this->tenantName = $tenantName;
        $this->tenantAddress = $tenantAddress;
        $this->bankName = $bankName;
        $this->accountSummary = $accountSummary;
    }

    public function getTenantName(): string
    {
        return $this->tenantName;
    }

    public function getTenantAddress(): string
    {
        return $this->tenantAddress;
    }

    public function getBankName(): string
    {
        return $this->bankName;
    }

    public function getAccountSummary(): array
    {
        return $this->accountSummary;
    }
}
