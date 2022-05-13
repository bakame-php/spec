<?php

namespace Bakame\Specification;

final class OrX implements Specification
{
    public function __construct(
        private Specification $specificationA,
        private Specification $specificationB
    ) {
    }

    public function isSatisfiedBy(mixed $subject): bool
    {
        return $this->specificationA->isSatisfiedBy($subject)
            || $this->specificationB->isSatisfiedBy($subject);
    }
}
