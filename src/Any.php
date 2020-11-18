<?php

declare(strict_types=1);

namespace Bakame\Specification;

use function count;

final class Any implements Composite
{
    /**
     * @var array<Specification>
     */
    private $specifications;

    /**
     * @param iterable<Specification> $specifications
     */
    public static function fromSpecifications(iterable $specifications): self
    {
        return new self(...$specifications);
    }

    public function __construct(Specification ...$specifications)
    {
        $this->specifications = $specifications;
    }

    public function count(): int
    {
        return count($this->specifications);
    }

    public function withAddedSpecification(Specification $specification): self
    {
        $clone = clone $this;
        $clone->specifications[] = $specification;

        return $clone;
    }

    public function isSatisfiedBy($subject): bool
    {
        foreach ($this->specifications as $specification) {
            if ($specification->isSatisfiedBy($subject)) {
                return true;
            }
        }

        return [] === $this->specifications;
    }
}
