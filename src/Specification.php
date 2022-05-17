<?php

declare(strict_types=1);

namespace Bakame\Specification;

interface Specification
{
    /**
     * Returns true if the subject satisfies the specification or false otherwise.
     */
    public function isSatisfiedBy(mixed $subject): bool;
}
