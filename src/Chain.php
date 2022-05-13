<?php

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
        return new self(All::from(...$specification));
    }

    public static function any(Specification ...$specification): self
    {
        return new self(Any::from(...$specification));
    }

    public static function none(Specification ...$specification): self
    {
        return new self(None::from(...$specification));
    }

    public function isSatisfiedBy(mixed $subject): bool
    {
        return $this->specification->isSatisfiedBy($subject);
    }

    public function andX(Specification $specification): Composite
    {
        return new self(new AndX($this->specification, $specification));
    }

    public function orX(Specification $specification): Composite
    {
        return new self(new OrX($this->specification, $specification));
    }

    public function not(): Composite
    {
        return new self(new Not($this->specification));
    }
}
