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
abstract class AbstractComposite implements Composite, Countable, IteratorAggregate
{
    /**
     * @var array<Specification>
     */
    protected array $specifications;

    final protected function __construct(Specification ...$specifications)
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

    public function withAddedSpecification(Specification ...$specifications): self
    {
        $specifications = array_merge($this->specifications, $specifications);
        if ($specifications === $this->specifications) {
            return $this;
        }

        $clone = clone $this;
        $clone->specifications = $specifications;

        return $clone;
    }

    abstract public function isSatisfiedBy($subject): bool;
}
