<?php

declare(strict_types=1);

namespace Bakame\Specification;

use PhpSpec\ObjectBehavior;

final class ChainSpec extends ObjectBehavior
{
    public function let(Specification $spec): void
    {
        $this->beConstructedThrough('one', [$spec]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Chain::class);
    }

    public function it_implements_the_specification_interface(): void
    {
        $this->shouldImplement(Specification::class);
    }

    public function it_implements_the_composite_interface(): void
    {
        $this->shouldImplement(Composite::class);
    }

    public function it_returns_the_decorated_specification(Specification $spec): void
    {
        $this->specification()->shouldBe($spec);
    }

    public function it_can_composite_with_logicial_and(Specification $spec, Specification $spec2): void
    {
        $this->and($spec2)->specification()->shouldBeLike(new All($spec->getWrappedObject(), $spec2->getWrappedObject()));
    }

    public function it_can_composite_with_logicial_or(Specification $spec, Specification $spec2): void
    {
        $this->or($spec2)->specification()->shouldBeLike(new Any($spec->getWrappedObject(), $spec2->getWrappedObject()));
    }

    public function it_can_composite_with_logicial_andNot(Specification $spec, Specification $spec2): void
    {
        $this->andNot($spec2)->specification()->shouldBeLike(new All($spec->getWrappedObject(), new None($spec2->getWrappedObject())));
    }

    public function it_can_composite_with_logicial_orNot(Specification $spec, Specification $spec2): void
    {
        $this->orNot($spec2)->specification()->shouldBeLike(new Any($spec->getWrappedObject(), new None($spec2->getWrappedObject())));
    }

    public function it_can_composite_with_logicial_not(Specification $spec): void
    {
        $this->not()->specification()->shouldBeLike(new None($spec->getWrappedObject()));
    }

    public function it_can_check_specification_validity(Specification $spec, Specification $spec2): void
    {
        $spec->isSatisfiedBy('anything')->willReturn(true);
        $spec2->isSatisfiedBy('anything')->willReturn(false);

        $this->andNot($spec2)->specification()->shouldBeLike(new All($spec->getWrappedObject(), new None($spec2->getWrappedObject())));
        $this->isSatisfiedBy('anything')->shouldEqual(true);
    }
}
