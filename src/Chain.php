<?php

declare(strict_types=1);

namespace Bakame\Specification;

final class Chain implements Composite
{
    private function __construct(private Specification $specification)
    {
    }

    public function specification(): Specification
    {
        return $this->specification;
    }

    public static function one(Specification $specification): self
    {
        return new self($specification);
    }

    public static function all(Specification ...$specification): self
    {
        return new self(new All(...$specification));
    }

    public static function any(Specification ...$specification): self
    {
        return new self(new Any(...$specification));
    }

    public static function none(Specification ...$specification): self
    {
        return new self(new None(...$specification));
    }

    public function isSatisfiedBy(mixed $subject): bool
    {
        return $this->specification->isSatisfiedBy($subject);
    }

    public function andX(Specification $specification): Composite
    {
        return new self(new AndX($this->specification, $specification));
    }

    public function andNotX(Specification $specification): Composite
    {
        return new self(new AndNotX($this->specification, $specification));
    }

    public function orX(Specification $specification): Composite
    {
        return new self(new OrX($this->specification, $specification));
    }

    public function orNotX(Specification $specification): Composite
    {
        return new self(new OrNotX($this->specification, $specification));
    }

    public function not(): Composite
    {
        return new self(new Not($this->specification));
    }
}
