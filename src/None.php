<?php

declare(strict_types=1);

namespace Bakame\Specification;

use Countable;
use function count;

final class None implements Specification, Countable
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
            if (true === $specification->isSatisfiedBy($subject)) {
                return false;
            }
        }

        return true;
    }
}
