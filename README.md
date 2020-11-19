# Spec

A Simple Specification library for PHP

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build](https://github.com/bakame-php/spec/workflows/build/badge.svg)](https://github.com/bakame-php/spec/actions?query=workflow%3A%22build%22)

This is a fork of [kayladnls/spec](https://github.com/greydnls/spec).

### System Requirements

You need:

- **PHP >= 7.4** but the latest stable version of PHP is recommended

### Installation

```
composer require bakame/spec
```

### What is it?

> "the specification pattern is a particular software design pattern, 
whereby business rules can be recombined by chaining the business 
rules together using boolean logic. The pattern is frequently used in 
the context of domain-driven design." -- [wikipedia](https://en.wikipedia.org/wiki/Specification_pattern)

### How do I use it?

~~~php
<?php

use App\Specification\MustHaveFourLegs;
use App\Specification\MustHaveStripesSpec;
use App\Specification\IsLizardSpec;
use Bakame\Specification\All;
use Bakame\Specification\Any;
use Bakame\Specification\None;

$allSpecs = All::fromSpecifications([new MustHaveFourLegs(), new MustHaveStripesSpec()]);
$noneSpec = new None(new IsLizardSpec(), new MustHaveStripesSpec());
$anySpec = (new Any(new IsLizardSpec()))->withAddedSpecification($allSpecs);

if ($allSpecs->isSatisfiedBy($zebra)) {
	// Do Some cool Zebra Stuff here. 
} 

if ($anySpec->isSatisfiedBy($iguana)) {
    // Do Some cool With the Iguana too.
}

if ($noneSpec->isSatisfiedBy($elephpant)){ 
    //$elephpant only loves PHP!
}
~~~

Happy Coding!
