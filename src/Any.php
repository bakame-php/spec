<?php

declare(strict_types=1);

namespace Bakame\Specification;

final class Any implements Composite
{
    private function __construct(private Specifications $specifications)
    {
    }

    public static function fromSpecifications(Specifications $specifications): self
    {
        return new self($specifications);
    }

    public static function fromList(Specification ...$specifications): self
    {
        return new self(Specifications::fromList(...$specifications));
    }

    public function specifications(): Specifications
    {
        return $this->specifications;
    }

    public function isSatisfiedBy($subject): bool
    {
        foreach ($this->specifications as $specification) {
            if ($specification->isSatisfiedBy($subject)) {
                return true;
            }
        }

        return 0 === count($this->specifications);
    }
}
