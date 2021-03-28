<?php

declare(strict_types=1);

namespace Bakame\Specification;

interface Composite extends Specification
{
    public function specifications(): Specifications;
}
