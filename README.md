# Spec

Implementing the Specification pattern in PHP

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build](https://github.com/bakame-php/spec/workflows/build/badge.svg)](https://github.com/bakame-php/spec/actions?query=workflow%3A%22build%22)
[![Latest Version](https://img.shields.io/github/release/bakame-php/spec.svg?style=flat-square)](https://github.com/bakame-php/spec/releases)
[![Total Downloads](https://img.shields.io/packagist/dt/bakame/spec.svg?style=flat-square)](https://packagist.org/packages/bakame/spec)
[![Sponsor development of this project](https://img.shields.io/badge/sponsor%20this%20package-%E2%9D%A4-ff69b4.svg?style=flat-square)](https://github.com/sponsors/nyamsprod)

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

Each rule that needs to be used MUST implement the `Bakame\Specification\Specification` interface.

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
| Any     | At least one of the specifications provided must be satisfied      | `Chain::any` named constructor  |
| None    | None of all provided specification must be satisfied by the author | `Chain::none` named constructor |
| AndX    | Combined two specifications where both must be satisfied           | `Chain::andX` method            |
| OrX     | Combined two specifications where at least one must be satisfied   | `Chain::orX` method             |
| Not     | Returns the opposite result of the provided specification          | `Chain::not` method             |

Creating more complex rules that you can individually test becomes trivial as do their maintenance.

~~~php
<?php

use App\Specification\MustHaveFourLegs;
use App\Specification\MustHaveStripes;
use App\Specification\IsLizard;
use Bakame\Specification\Chain;

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

[1]: https://www.rfc-editor.org/rfc/rfc8941.html
[2]: https://www.ietf.org/id/draft-ietf-httpbis-retrofit-00.html
[3]: https://www.rfc-editor.org/rfc/rfc8941.html#section-3.3
[4]: https://www.php-fig.org/psr/psr-4/


This is a fork of [kayladnls/spec](https://github.com/greydnls/spec).
