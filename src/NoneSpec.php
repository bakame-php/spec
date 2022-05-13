<?php

declare(strict_types=1);

namespace Bakame\Specification;

use PhpSpec\ObjectBehavior;

final class NoneSpec extends ObjectBehavior
{
    public function let(Specification $spec): void
    {
        $this->beConstructedThrough('from', [$spec]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(None::class);
    }

    public function it_implements_the_specification_interface(): void
    {
        $this->shouldImplement(Specification::class);
    }

    public function it_will_pass_with_a_false(Specification $spec): void
    {
        $spec->isSatisfiedBy('anything')->willReturn(false);

        $this->isSatisfiedBy('anything')->shouldEqual(true);
    }

    public function it_will_fail_with_a_true(Specification $spec): void
    {
        $spec->isSatisfiedBy('anything')->willReturn(true);

        $this->beConstructedThrough('fromList', [[$spec->getWrappedObject()]]);

        $this->isSatisfiedBy('anything')->shouldEqual(false);
    }
}
