<?php

declare(strict_types=1);

namespace Bakame\Specification;

use PhpSpec\ObjectBehavior;

final class NoneSpec extends ObjectBehavior
{
    public function let(Specification $spec): void
    {
        $this->beConstructedThrough('fromList', [$spec]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(None::class);
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

    public function it_will_pass_with_a_false(Specification $spec): void
    {
        $spec->isSatisfiedBy('anything')->willReturn(false);

        $this->isSatisfiedBy('anything')->shouldEqual(true);
    }

    public function it_will_fail_with_a_true(Specification $spec): void
    {
        $spec->isSatisfiedBy('anything')->willReturn(true);

        $this->beConstructedThrough('fromSpecifications', [Specifications::fromList($spec->getWrappedObject())]);

        $this->isSatisfiedBy('anything')->shouldEqual(false);
    }
}
