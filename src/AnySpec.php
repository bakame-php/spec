<?php

declare(strict_types=1);

namespace Bakame\Specification;

use PhpSpec\ObjectBehavior;

final class AnySpec extends ObjectBehavior
{
    public function let(Specification $spec1, Specification $spec2): void
    {
        $this->beConstructedThrough('fromList', [$spec1, $spec2]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Any::class);
    }

    public function it_implements_the_specification_interface(): void
    {
        $this->shouldBeAnInstanceOf(Specification::class);
    }

    public function it_implements_the_composite_interface(): void
    {
        $this->shouldBeAnInstanceOf(Composite::class);
        $this->specifications()->shouldBeAnInstanceOf(Specifications::class);
    }

    public function it_will_pass_with_two_true_values(Specification $spec1, Specification $spec2): void
    {
        $spec1->isSatisfiedBy('anything')->willReturn(true);
        $spec2->isSatisfiedBy('anything')->willReturn(true);

        $this->isSatisfiedBy('anything')->shouldEqual(true);
    }

    public function it_will_pass_with_one_true_one_false(Specification $spec1, Specification $spec2): void
    {
        $spec1->isSatisfiedBy('anything')->willReturn(false);
        $spec2->isSatisfiedBy('anything')->willReturn(true);

        $this->beConstructedThrough('fromSpecifications', [
            Specifications::fromList($spec1->getWrappedObject(), $spec2->getWrappedObject()),
        ]);

        $this->isSatisfiedBy('anything')->shouldEqual(true);
    }

    public function it_will_fail_with_two_false(Specification $spec1, Specification $spec2): void
    {
        $spec1->isSatisfiedBy('anything')->willReturn(false);
        $spec2->isSatisfiedBy('anything')->willReturn(false);

        $this->isSatisfiedBy('anything')->shouldEqual(false);
    }
}
