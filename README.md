# Spec

Implementing the Specification pattern in PHP

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build](https://github.com/bakame-php/spec/workflows/build/badge.svg)](https://github.com/bakame-php/spec/actions?query=workflow%3A%22build%22)
[![Latest Version](https://img.shields.io/github/release/bakame-php/spec.svg?style=flat-square)](https://github.com/bakame-php/spec/releases)
[![Total Downloads](https://img.shields.io/packagist/dt/bakame/spec.svg?style=flat-square)](https://packagist.org/packages/bakame/spec)
[![Sponsor development of this project](https://img.shields.io/badge/sponsor%20this%20package-%E2%9D%A4-ff69b4.svg?style=flat-square)](https://github.com/sponsors/nyamsprod)

System Requirements
------------

You need:

- **PHP >= 8.0** but the latest stable version of PHP is recommended

Installation
------------

Use composer:

```
composer require bakame/spec
```

or download the library and:

- use any other [PSR-4](https://www.php-fig.org/psr/psr-4/) compatible autoloader.
- use the bundle autoloader script as shown below:

~~~php
require 'path/to/spec/repo/autoload.php';

use Bakame\Http\Specification\Chain;

$spec = Chain::one(new Rule1())
    ->and(new Rule2(), new Rule3())
    ->orNot(new Rule4());

$spec->isSatisfiedBy($subject);
~~~

What is it ?
------------

> "the specification pattern is a particular software design pattern, 
whereby business rules can be recombined by chaining the business 
rules together using boolean logic. The pattern is frequently used in 
the context of domain-driven design." -- [wikipedia](https://en.wikipedia.org/wiki/Specification_pattern)

How do I use it?
------------

Each rule that needs to be validated MUST implement the `Bakame\Specification\Specification` interface.

Here's a quick example. First, create a specification implementing class.

~~~php
<?php

use Bakame\Specification\Specification;

final class OverDueSpecification implements Specification
{
    public function __construct(
        private DateTimeImmutable $date = new DateTimeImmutable('NOW', new DateTimeZone('UTC'))
    ) {
    }

    public function isSatisfiedBy(mixed $subject) : bool
    {
        return $subject instanceof Invoice
            && $subject->getDueDate() < $this->date;
    }
}
~~~

Then using the decorator class `Bakame\Specification\Chain` and all the specifications 
created, it becomes straightforward to logically apply all the specification 
as expected by your business rules. 

Here's how the Wikipedia page example is adapted using the library.

~~~php
<?php

use Bakame\Specification\Chain;

$overDue = new OverDueSpecification();
$noticeSent = new NoticeSentSpecification();
$inCollection = new InCollectionSpecification();

// example of specification pattern logic chaining
$sendToCollection = Chain::one($overDue)
    ->and($noticeSent)
    ->andNot($inCollection);

$invoiceCollection = $service->getInvoices();

foreach ($invoiceCollection as $invoice) {
    if ($sendToCollection->isSatisfiedBy($invoice))  {
        $invoice->sendToCollection();
    }
}
~~~

The `Bakame\Specification\Chain` class exposes the following logical methods

- `Chain::and` the resulting `isSatisfiedBy` will return true if the current specification and the those added are all satisfied
- `Chain::or` the resulting `isSatisfiedBy` will return true if the at least one of the specifications is satisfied
- `Chain::andNot` the resulting `isSatisfiedBy` will return true if the current specification is satisfied AND the ones added are not
- `Chain::orNot` the resulting `isSatisfiedBy` will return true if the current specification is satisfied OR the ones added are not
- `Chain::not` the resulting `isSatisfiedBy` will return the opposite of the current specification.

To initiate a new specification logic chain the class exposes 4 named constructors

- `Chain::one` returns a new instance with a specification attach to it
- `Chain::all` returns a new instance with all specifications attach to it like `Chain::and`
- `Chain::any` returns a new instance with all specifications attach to it like `Chain::or`
- `Chain::none` returns a new instance with all specifications attach to it like `Chain::not`

Under the hood the `Bakame\Specification\Chain` class calls and uses the following classes
to allow the implementations of complex business rules.

| Classes                     | Logical usage                                                      | 
|-----------------------------|--------------------------------------------------------------------|
| `Bakame\Specification\All`  | All specifications must be satisfied by the subject                |
| `Bakame\Specification\Any`  | At least one of the specifications provided must be satisfied      |
| `Bakame\Specification\None` | None of all provided specification must be satisfied by the author |

All the logical methods from the  `Bakame\Specification\Chain` accept variadic `Bakame\Specification\Specification` implemented classes.

Creating more complex rules that you can individually test becomes trivial as do their maintenance.

~~~php
<?php

use App\Specification\MustHaveFourLegs;
use App\Specification\MustHaveStripes;
use App\Specification\IsLizard;
use Bakame\Specification\Chain;

$allSpecs = Chain::one(new MustHaveFourLegs())->and(new MustHaveStripes());
$anySpec = $allSpecs->or(new IsLizard());
$noneSpec = Chain::none(new IsLizard(), new MustHaveStripes());

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

Contributing
-------

Contributions are welcome and will be fully credited. Please see [CONTRIBUTING](.github/CONTRIBUTING.md) and [CODE OF CONDUCT](.github/CODE_OF_CONDUCT.md) for details.

Testing
-------

The library:

- has a [PHPSpec](http://phpspec.net/en/stable/) test suite
- has a coding style compliance test suite using [PHP CS Fixer](https://cs.sensiolabs.org/).
- has a code analysis compliance test suite using [PHPStan](https://phpstan.org/) and [Psalm](https://psalm.dev).

To run the tests, run the following command from the project folder.

``` bash
$ composer test
```

Security
-------

If you discover any security related issues, please email nyamsprod@gmail.com instead of using the issue tracker.

Credits
-------

- [ignace nyamagana butera](https://github.com/nyamsprod)
- [All Contributors](https://github.com/bakame-php/spec/contributors)

Attribution
-------

The package is a fork of the work of [greydnls](https://twitter.com/greydnls) on [greydnls/spec](https://github.com/gapple/structured-fields/).

License
-------

The MIT License (MIT). Please see [License File](LICENSE) for more information.