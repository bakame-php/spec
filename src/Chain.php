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

    public function and(Specification ...$specification): Composite
    {
        return self::all($this->specification, ...$specification);
    }

    public function andNot(Specification ...$specification): Composite
    {
        return self::all($this->specification, new None(...$specification));
    }

    public function or(Specification ...$specification): Composite
    {
        return self::any($this->specification, ...$specification);
    }

    public function orNot(Specification ...$specification): Composite
    {
        return self::any($this->specification, new None(...$specification));
    }

    public function not(): Composite
    {
        return self::none($this->specification);
    }
}
