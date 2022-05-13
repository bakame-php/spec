# Spec

Implementing the Specification pattern in PHP

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build](https://github.com/bakame-php/spec/workflows/build/badge.svg)](https://github.com/bakame-php/spec/actions?query=workflow%3A%22build%22)
[![Latest Version](https://img.shields.io/github/release/bakame-php/spec.svg?style=flat-square)](https://github.com/bakame-php/spec/releases)
[![Total Downloads](https://img.shields.io/packagist/dt/bakame/spec.svg?style=flat-square)](https://packagist.org/packages/bakame/spec)
[![Sponsor development of this project](https://img.shields.io/badge/sponsor%20this%20package-%E2%9D%A4-ff69b4.svg?style=flat-square)](https://github.com/sponsors/nyamsprod)

This is a fork of [kayladnls/spec](https://github.com/greydnls/spec).

### System Requirements

You need:

- **PHP >= 8.0** but the latest stable version of PHP is recommended

### Installation

```
composer require bakame/spec
```

### What is it ?

> "the specification pattern is a particular software design pattern, 
whereby business rules can be recombined by chaining the business 
rules together using boolean logic. The pattern is frequently used in 
the context of domain-driven design." -- [wikipedia](https://en.wikipedia.org/wiki/Specification_pattern)

### How do I use it?

Each object added to one of the logical instance must implement the `Bakame\Specification\Specification` interface.

Here's a quick example. First you create your Specification implementing class.

~~~php
<?php

use Bakame\Specification\Specification;

final class OverDueSpecification implements Specification
{
    public function __construct(private DateTimeImmutable $date = new DateTimeImmutable('NOW', new DateTimeZone('UTC')))

    public function isSatisfiedBy(mixed $subject) : bool
    {
        return $subject instanceof Invoice
            $$ $subject->getDueDate() < $this->date;
    }
}
~~~

Then using the special `Bakame\Specification\Chain` class and all the specifications you have 
created you can link all specification as needed. 

Here's how the Wikipedia page example is adapted using the library.

~~~php
<?php

use Bakame\Specification\Chain;

$overDue = new OverDueSpecification();
$noticeSent = new NoticeSentSpecification();
$inCollection = new InCollectionSpecification();

// example of specification pattern logic chaining
$sendToCollection = Chain::one($overDue)
    ->andX($noticeSent)
    ->andX(Chain::one($inCollection)->not());

$invoiceCollection = $service->getInvoices();

foreach ($invoiceCollection as $invoice) {
    if ($sendToCollection->isSatisfiedBy($invoice))  {
        $invoice->sendToCollection();
    }
}
~~~

Under the hood the `Specification\Chain` class calls and uses the following classes
to allow the implementations of complex business rules.

| Classes | Logical usage                                                      | Chain methods                   |
|---------|--------------------------------------------------------------------|---------------------------------|
| All     | All specifications must be satisfied by the subject                | `Chain::all` named constructor  |
| AndX    | Combined two specifications where both must be satisfied           | `Chain::andX` method            |
| Any     | At least one of the specifications provided must be satisfied      | `Chain::any` named constructor  |
| None    | None of all provided specification must be satisfied by the author | `Chain::none` named constructor |
| OrX     | Combined two specifications where at least one must be satisfied   | `Chain::orX` method             |
| Not     | Returns the opposite result of the provided specification          | `Chain::not` method             |

Creating your own specification is straightforward as you can see below.

~~~php
<?php

use App\Specification\MustHaveFourLegs;
use App\Specification\MustHaveStripes;
use App\Specification\IsLizard;
use Bakame\Specification;

$allSpecs = Chain::all(new MustHaveFourLegs(), new MustHaveStripes());
$anySpec = $allSpecs->orX(new IsLizard());
$noneSpec = Chain::all(new IsLizard(), new MustHaveStripes())->not();

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