<?php

declare(strict_types=1);

namespace Bakame\Specification;

use Countable;
use Iterator;
use IteratorAggregate;
use function count;

/**
 * @implements IteratorAggregate<Specification>
 */
final class None implements Composite, Countable, IteratorAggregate
{
    /**
     * @var array<Specification>
     */
    private array $specifications;

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

    /**
     * @return Iterator<Specification>
     */
    public function getIterator(): Iterator
    {
        foreach ($this->specifications as $specification) {
            yield $specification;
        }
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
