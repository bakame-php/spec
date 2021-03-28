<?php

declare(strict_types=1);

namespace Bakame\Specification;

use Closure;
use Countable;
use Iterator;
use IteratorAggregate;
use function array_merge;
use function count;

/**
 * @implements IteratorAggregate<Specification>
 */
final class Specifications implements Countable, IteratorAggregate
{
    /**
     * @var array<Specification>
     */
    private array $specifications;

    private function __construct(Specification ...$specifications)
    {
        $this->specifications = $specifications;
    }

    public static function fromList(Specification ...$specifications): self
    {
        return new self(...$specifications);
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
        return $this->cloneWith(array_merge($this->specifications, $specifications));
    }

    /**
     * @param array<Specification> $newSpecifications
     */
    private function cloneWith(array $newSpecifications): self
    {
        if ($newSpecifications === $this->specifications) {
            return $this;
        }

        $newInstance = clone $this;
        $newInstance->specifications = $newSpecifications;

        return $newInstance;
    }

    public function withoutSpecification(Specification ...$specifications): self
    {
        if ([] === $specifications) {
            return $this;
        }

        return $this->filter(
            fn (Specification $specification): bool => ! in_array($specification, $specifications, true)
        );
    }

    /**
     * Filters the specification according to the given predicate.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the interval which validate the predicate.
     */
    public function filter(Closure $predicate): self
    {
        if ([] === $this->specifications) {
            return $this;
        }

        return $this->cloneWith(array_filter($this->specifications, $predicate, ARRAY_FILTER_USE_BOTH));
    }

    /**
     * Returns an instance where the given function is applied to each element in
     * the collection. The closure MUST return a Specification object and takes a Specification
     * and its associated key as argument.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the returned intervals.
     *
     * @psalm-param Closure(Specification=):Specification $func
     */
    public function map(Closure $func): self
    {
        return $this->cloneWith(array_map($func, $this->specifications));
    }
}
