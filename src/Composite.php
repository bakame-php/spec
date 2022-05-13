<?php

namespace Bakame\Specification;

interface Composite extends Specification
{
    public function andX(Specification $specification): Composite;
    public function andNotX(Specification $specification): Composite;
    public function orX(Specification $specification): Composite;
    public function orNotX(Specification $specification): Composite;
    public function not(): Composite;
}
