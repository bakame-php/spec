<?php

declare(strict_types=1);

namespace Bakame\Specification;

use Countable;
use Iterator;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<Specification>
 */
final class Any implements Specification, Countable, IteratorAggregate
{
    /** @var array<Specification> */
    private array $specifications;

    final public function __construct(Specification ...$specifications)
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
        foreach ($this as $specification) {
            yield $specification;
        }
    }

    public function isSatisfiedBy(mixed $subject): bool
    {
        foreach ($this->specifications as $specification) {
            if ($specification->isSatisfiedBy($subject)) {
                return true;
            }
        }

        return [] === $this->specifications;
    }
}
