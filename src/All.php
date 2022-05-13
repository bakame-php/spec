<?php

declare(strict_types=1);

namespace Bakame\Specification;

final class All extends SpecificationAggregate
{
    public function isSatisfiedBy(mixed $subject): bool
    {
        foreach ($this->specifications as $specification) {
            if (! $specification->isSatisfiedBy($subject)) {
                return false;
            }
        }

        return true;
    }
}
