<?php

declare(strict_types=1);

namespace Bakame\Specification;

final class None implements Specification
{
    private function __construct(private Specifications $specifications)
    {
    }

    /**
     * @param iterable<Specification> $specifications
     */
    public static function fromSpecifications(iterable $specifications): self
    {
        return match (true) {
            $specifications instanceof Specifications => new self($specifications),
            is_array($specifications) => new self(Specifications::fromList(...$specifications)),
            default => new self(Specifications::fromList(...iterator_to_array($specifications, false))),
        };
    }

    public static function fromList(Specification ...$specifications): self
    {
        return new self(Specifications::fromList(...$specifications));
    }

    public function specifications(): Specifications
    {
        return $this->specifications;
    }

    public function isSatisfiedBy(mixed $subject): bool
    {
        foreach ($this->specifications as $specification) {
            if (true === $specification->isSatisfiedBy($subject)) {
                return false;
            }
        }

        return true;
    }
}
