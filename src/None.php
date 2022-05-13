<?php

declare(strict_types=1);

namespace Bakame\Specification;

final class None extends SpecificationAggregate
{
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
