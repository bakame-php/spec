<?php

declare(strict_types=1);

namespace Bakame\Specification;

use Countable;
use Iterator;
use IteratorAggregate;
use function array_merge;
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
    public static function fromList(iterable $specifications): self
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

    public function withAddedSpecification(Specification $specification, Specification ...$specifications): self
    {
        $clone = clone $this;
        $clone->specifications = array_merge($clone->specifications, [$specification], $specifications);

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
