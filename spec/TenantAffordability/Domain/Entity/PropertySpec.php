<?php declare(strict_types=1);

namespace spec\GoodLord\TenantAffordability\Domain\Entity;

use GoodLord\TenantAffordability\Domain\Entity\Property;
use Litipk\BigNumbers\Decimal;
use PhpSpec\ObjectBehavior;

class PropertySpec extends ObjectBehavior
{
    public function let(Decimal $pcm)
    {
        $id = 1;
        $address = "Some address";

        $this->beConstructedWith($id, $address, $pcm);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Property::class);
    }

    public function it_can_return_its_id()
    {
        $this->getId()->shouldBe(1);
    }

    public function it_can_return_its_address()
    {
        $this->getAddress()->shouldBe("Some address");
    }

    public function it_can_return_its_pcm($pcm)
    {
        $this->getPcm()->shouldBe($pcm);
    }
}
