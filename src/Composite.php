<?php

namespace Bakame\Specification;

interface Composite extends Specification
{
    public function and(Specification $specification): Composite;
    public function andNot(Specification $specification): Composite;
    public function or(Specification $specification): Composite;
    public function orNot(Specification $specification): Composite;
    public function not(): Composite;
}
