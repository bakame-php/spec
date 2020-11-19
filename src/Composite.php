<?php

declare(strict_types=1);

namespace Bakame\Specification;

interface Composite extends Specification
{
    /**
     * @return static
     */
    public function withAddedSpecification(Specification $specification): self;
}
