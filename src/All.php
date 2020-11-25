<?php

declare(strict_types=1);

namespace Bakame\Specification;

final class All extends AbstractComposite
{
    public static function fromList(Specification ...$specifications): self
    {
        return new self(...$specifications);
    }

    public function isSatisfiedBy($subject): bool
    {
        foreach ($this->specifications as $specification) {
            if (! $specification->isSatisfiedBy($subject)) {
                return false;
            }
        }

        return true;
    }
}
