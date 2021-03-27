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
final class Any implements Composite, Countable, IteratorAggregate
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

    public function isSatisfiedBy($subject): bool
    {
        foreach ($this as $specification) {
            if ($specification->isSatisfiedBy($subject)) {
                return true;
            }
        }

        return [] === $this->specifications;
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
        if ([] === $specifications || [] === $this->specifications) {
            return $this;
        }

        return $this->cloneWith(array_filter(
            $this->specifications,
            fn (Specification $specification): bool => ! in_array($specification, $specifications, true)
        ));
    }
}
