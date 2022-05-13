<?php

declare(strict_types=1);

namespace Bakame\Specification;

use PhpSpec\ObjectBehavior;

final class NotSpec extends ObjectBehavior
{
    public function let(Specification $spec): void
    {
        $this->beConstructedWith($spec);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Not::class);
    }

    public function it_implements_the_specification_interface(): void
    {
        $this->shouldImplement(Specification::class);
    }

    public function it_will_pass_with_failing_spec(Specification $spec): void
    {
        $spec->isSatisfiedBy('anything')->willReturn(false);

        $this->isSatisfiedBy('anything')->shouldEqual(true);
    }

    public function it_will_fail_with_passing_spec(Specification $spec): void
    {
        $spec->isSatisfiedBy('anything')->willReturn(true);

        $this->isSatisfiedBy('anything')->shouldEqual(false);
    }
}
