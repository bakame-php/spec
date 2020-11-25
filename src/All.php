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
final class All implements Composite, Countable, IteratorAggregate
{
    /**
     * @var array<Specification>
     */
    private array $specifications;

    public static function fromList(Specification ...$specifications): self
    {
        return new self(...$specifications);
    }

    private function __construct(Specification ...$specifications)
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

        return new self(...$specifications);
    }

    public function isSatisfiedBy($subject): bool
    {
        foreach ($this->specifications as $specification) {
            if (! $specification->isSatisfiedBy($subject)) {
                return false;
            }
        }

        return true;
    }
}
