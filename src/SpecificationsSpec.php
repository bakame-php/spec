<?php

declare(strict_types=1);

namespace Bakame\Specification;

use Countable;
use IteratorAggregate;
use PhpSpec\ObjectBehavior;

final class SpecificationsSpec extends ObjectBehavior
{
    public function let(Specification $spec1, Specification $spec2): void
    {
        $this->beConstructedThrough('fromList', [$spec1, $spec2]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Specifications::class);
    }

    public function it_implements_the_countable_interface(): void
    {
        $this->shouldBeAnInstanceOf(Countable::class);
    }

    public function it_implements_the_iterator_aggregate_interface(): void
    {
        $this->shouldBeAnInstanceOf(IteratorAggregate::class);
    }

    public function it_can_accept_more_specifications(Specification $spec1, Specification $spec2, Specification $spec3): void
    {
        $newInstance = $this->withAddedSpecification($spec3);
        $newInstance->shouldBeAnInstanceOf(Specifications::class);
        $newInstance->count()->shouldBe(3);
        $this->count()->shouldBe(2);
    }

    public function it_can_remove_specifications(Specification $spec1, Specification $spec2, Specification $spec3): void
    {
        $newInstance = $this->withAddedSpecification($spec3)->withoutSpecification($spec2);
        $newInstance->shouldBeAnInstanceOf(Specifications::class);
        $newInstance->count()->shouldBe(2);
        $this->count()->shouldBe(2);
        $newInstance->shouldContain($spec3);
        $newInstance->shouldNotContain($spec2);
    }

    public function it_returns_the_same_instance_if_no_specifications_is_added(): void
    {
        $newInstance = $this->withAddedSpecification();
        $newInstance->shouldBeAnInstanceOf(Specifications::class);
        $newInstance->count()->shouldBe(2);
        $this->count()->shouldBe(2);
        $newInstance->shouldBe($this);
    }

    public function it_returns_the_same_instance_if_no_specifications_is_submitted_for_removal(Specification $spec): void
    {
        $this->beConstructedThrough('fromList', [$spec]);
        $newInstance = $this->withoutSpecification();
        $newInstance->shouldBeAnInstanceOf(Specifications::class);
        $newInstance->count()->shouldBe(1);
        $this->count()->shouldBe(1);
        $newInstance->shouldBe($this);
    }

    public function it_returns_the_same_instance_if_no_specifications_can_be_removed(Specification $spec): void
    {
        $this->beConstructedThrough('fromList', []);
        $newInstance = $this->withoutSpecification($spec);
        $newInstance->shouldBeAnInstanceOf(Specifications::class);
        $newInstance->count()->shouldBe(0);
        $this->count()->shouldBe(0);
        $newInstance->shouldBe($this);
    }

    public function it_can_map_all_instances(Specification $spec): void
    {
        $this->beConstructedThrough('fromList', [$spec]);
        $newInstance = $this->map(fn (Specification $specification): Specification => $specification);
        $newInstance->shouldBeAnInstanceOf(Specifications::class);
        $newInstance->count()->shouldBe(1);
        $this->count()->shouldBe(1);
    }
}
