<?php

declare(strict_types=1);

namespace Bakame\Specification;

use PhpSpec\ObjectBehavior;

final class AndXSpec extends ObjectBehavior
{
    public function let(Specification $spec1, Specification $spec2): void
    {
        $this->beConstructedWith($spec1, $spec2);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(AndX::class);
    }

    public function it_implements_the_specification_interface(): void
    {
        $this->shouldImplement(Specification::class);
    }

    public function it_will_pass_with_both_spec_being_satisfied(Specification $spec1, Specification $spec2): void
    {
        $spec1->isSatisfiedBy('anything')->willReturn(true);
        $spec2->isSatisfiedBy('anything')->willReturn(true);

        $this->isSatisfiedBy('anything')->shouldEqual(true);
    }

    public function it_will_fail_with_at_least_one_spec_not_being_satisfied(Specification $spec1, Specification $spec2): void
    {
        $spec1->isSatisfiedBy('anything')->willReturn(false);
        $spec2->isSatisfiedBy('anything')->willReturn(true);

        $this->isSatisfiedBy('anything')->shouldEqual(false);
    }

    public function it_will_fail_with_both_spec_failing(Specification $spec1, Specification $spec2): void
    {
        $spec1->isSatisfiedBy('anything')->willReturn(false);
        $spec2->isSatisfiedBy('anything')->willReturn(false);

        $this->isSatisfiedBy('anything')->shouldEqual(false);
    }
}
