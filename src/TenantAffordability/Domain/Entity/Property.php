<?php declare(strict_types=1);

namespace GoodLord\TenantAffordability\Domain\Entity;

use Litipk\BigNumbers\Decimal;

class Property
{
    private $id;

    private $address;

    private $pcm;

    public function __construct(int $id, string $address, Decimal $pcm)
    {
        $this->id = $id;
        $this->address = $address;
        $this->pcm = $pcm;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPcm(): Decimal
    {
        return $this->pcm;
    }
}
