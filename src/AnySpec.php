<?php

declare(strict_types=1);

namespace Bakame\Specification;

use Countable;
use PhpSpec\ObjectBehavior;
use TypeError;

final class AnySpec extends ObjectBehavior
{
    public function let(Specification $spec1, Specification $spec2): void
    {
        $this->beConstructedWith($spec1, $spec2);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Any::class);
    }

    public function it_implements_the_specification_interface(): void
    {
        $this->shouldBeAnInstanceOf(Specification::class);
    }

    public function it_implements_the_countable_interface(): void
    {
        $this->shouldBeAnInstanceOf(Countable::class);
        $this->count()->shouldBe(2);
    }

    public function it_can_accept_more_specifications(Specification $spec1, Specification $spec2, Specification $spec3): void
    {
        $spec1->isSatisfiedBy('anything')->willReturn(true);
        $spec2->isSatisfiedBy('anything')->willReturn(true);

        $newInstance = $this->withAddedSpecification($spec3);
        $newInstance->shouldBeAnInstanceOf(Any::class);
        $newInstance->count()->shouldBe(3);
        $this->count()->shouldBe(2);
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

        $this->beConstructedThrough('fromSpecifications', [[$spec1, $spec2]]);

        $this->isSatisfiedBy('anything')->shouldEqual(true);
    }

    public function it_will_fail_with_two_false(Specification $spec1, Specification $spec2): void
    {
        $spec1->isSatisfiedBy('anything')->willReturn(false);
        $spec2->isSatisfiedBy('anything')->willReturn(false);

        $this->isSatisfiedBy('anything')->shouldEqual(false);
    }

    public function it_can_only_be_constructed_with_specs(): void
    {
        $this->beConstructedThrough('fromSpecifications', [['yellow', 'submarine']]);

        $this->shouldThrow(TypeError::class);
    }
}