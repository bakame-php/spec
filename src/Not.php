<?php

namespace Bakame\Specification;

final class Not implements Specification
{
    public function __construct(
        private Specification $specification,
    ) {
    }

    public function isSatisfiedBy(mixed $subject): bool
    {
        return !$this->specification->isSatisfiedBy($subject);
    }
}
