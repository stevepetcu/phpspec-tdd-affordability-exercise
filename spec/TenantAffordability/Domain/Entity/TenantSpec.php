<?php

namespace spec\GoodLord\TenantAffordability\Domain\Entity;

use GoodLord\TenantAffordability\Domain\Entity\Tenant;
use Litipk\BigNumbers\Decimal;
use PhpSpec\ObjectBehavior;

class TenantSpec extends ObjectBehavior
{
    public function let(Decimal $affordabilityScore)
    {
        $name = "Foo";
        $address = "Some Address 5";
        $bank = "Some Bank";

        $this->beConstructedWith($name, $address, $bank, $affordabilityScore);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Tenant::class);
    }

    public function it_can_return_its_name()
    {
        $this->getName()->shouldBe("Foo");
    }

    public function it_can_return_its_address()
    {
        $this->getAddress()->shouldBe("Some Address 5");
    }


    public function it_can_return_its_bank()
    {
        $this->getBank()->shouldBe("Some Bank");
    }

    public function it_can_return_its_affordability_score($affordabilityScore)
    {
        $this->getAffordabilityScore()->shouldBe($affordabilityScore);
    }
}
