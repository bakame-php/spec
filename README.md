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

Each object added to a `Bakame\Specification\Composite` instance must implement
the `Bakame\Specification\Specification` interface.

~~~php
<?php

use App\Specification\MustHaveFourLegs;
use App\Specification\MustHaveStripes;
use App\Specification\IsLizard;
use Bakame\Specification\All;
use Bakame\Specification\Any;
use Bakame\Specification\None;

$allSpecs = All::fromList(...[new MustHaveFourLegs(), new MustHaveStripes()]);
$anySpec = Any::fromList(new IsLizard(), $allSpecs);
$noneSpec = None::fromList(new IsLizard(), new MustHaveStripes());

if ($allSpecs->isSatisfiedBy($zebra)) {
    // Do some cool Zebra stuff here. 
} 

if ($anySpec->isSatisfiedBy($iguana)) {
    // Do some cool stuff with the Iguana too.
}

if ($noneSpec->isSatisfiedBy($elephpant)){ 
    //Elephpant only loves PHP!
}
~~~

Happy Coding!
