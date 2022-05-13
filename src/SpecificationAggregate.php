<?php

declare(strict_types=1);

namespace Bakame\Specification;

use Countable;
use Iterator;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<Specification>
 */
abstract class SpecificationAggregate implements Specification, Countable, IteratorAggregate
{
    /** @var array<Specification> */
    protected array $specifications;

    final protected function __construct(Specification ...$specifications)
    {
        $this->specifications = $specifications;
    }

    public static function from(Specification ...$specifications): static
    {
        return new static(...$specifications);
    }

    /**
     * @param iterable<Specification> $specifications
     */
    public static function fromList(iterable $specifications): static
    {
        return match (true) {
            is_array($specifications) => new static(...$specifications),
            default => new static(...iterator_to_array($specifications, false)),
        };
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

    abstract public function isSatisfiedBy(mixed $subject): bool;
}
