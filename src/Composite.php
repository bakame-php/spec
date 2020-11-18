<?php

declare(strict_types=1);

namespace Bakame\Specification;

interface Composite extends Specification, Countable
{
    public function withAddedSpecification(Specification $specification): self;
}
