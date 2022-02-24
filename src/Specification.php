<?php

namespace Bakame\Specification;

interface Specification
{
    /**
     * @param mixed $subject the item that needs to be validated
     */
    public function isSatisfiedBy(mixed $subject): bool;
}
