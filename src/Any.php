<?php

declare(strict_types=1);

namespace Bakame\Specification;

final class Any extends SpecificationAggregate
{
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
