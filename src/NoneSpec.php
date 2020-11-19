<?php

declare(strict_types=1);

namespace Bakame\Specification;

use Countable;
use IteratorAggregate;
use PhpSpec\ObjectBehavior;
use TypeError;

final class NoneSpec extends ObjectBehavior
{
    public function let(Specification $spec): void
    {
        $this->beConstructedWith($spec);
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
    }

    public function it_implements_the_countable_interface(): void
    {
        $this->shouldBeAnInstanceOf(Countable::class);
    }

    public function it_implements_the_iterator_aggregate_interface(): void
    {
        $this->shouldBeAnInstanceOf(IteratorAggregate::class);
    }

    public function it_can_accept_more_specifications(Specification $spec, Specification $spec2): void
    {
        $spec->isSatisfiedBy('anything')->willReturn(true);

        $newInstance = $this->withAddedSpecification($spec2);
        $newInstance->shouldBeAnInstanceOf(None::class);
        $newInstance->count()->shouldBe(2);
        $this->count()->shouldBe(1);
    }

    public function it_will_pass_with_a_false(Specification $spec): void
    {
        $spec->isSatisfiedBy('anything')->willReturn(false);

        $this->isSatisfiedBy('anything')->shouldEqual(true);
    }

    public function it_will_fail_with_a_true(Specification $spec): void
    {
        $spec->isSatisfiedBy('anything')->willReturn(true);

        $this->beConstructedThrough('fromSpecifications', [[$spec]]);

        $this->isSatisfiedBy('anything')->shouldEqual(false);
    }

    public function it_can_only_be_constructed_with_specs(): void
    {
        $this->beConstructedThrough('fromSpecifications', [['yellow', 'submarine']]);

        $this->shouldThrow(TypeError::class);
    }
}
