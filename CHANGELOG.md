# Changelog

All Notable changes to `bakame/spec` will be documented in this file

## [2.0.0] - 2022-05-16

### Added

- `Chain::and`, `Chain::andNot`, `Chain::or`, `Chain::orNot` methods

### Fixed

- All `Chain` methods now accepts variadic `Specification`.

### Deprecated

- none

### Removed

- `AndNotX`, `AndX`, `OrX`, `OrNotX`, `Not` classes without replacements you can emulate them via the `Chain` class usage
- `Chain::andX`, `Chain::andNotX`, `Chain::orX`, `Chain::orNotX` methods replaced by
  `Chain::and`, `Chain::andNot`, `Chain::or`, `Chain::orNot` methods

## [1.1.0] - 2022-05-13

### Added

- `AndNotX` and `OrNotX` Specifications
- `Composite::andNotX` and `Composite::orNotX` methods

### Fixed

- added missing `declare(strict_types=1);` declaration
- made protected properties private

### Deprecated

- none

### Removed

- none

## [1.0.1] - 2022-05-13

### Added

- none

### Fixed

- Remove development files from package download.

### Deprecated

- none

### Removed

- none

## [1.0.0] - 2022-05-13

**Initial release!**

[2.0.0]: https://github.com/bakame-php/spec/compare/1.1.0...2.0.0
[1.1.0]: https://github.com/bakame-php/spec/compare/1.0.1...1.1.0
[1.0.1]: https://github.com/bakame-php/spec/compare/1.0.0...1.0.1
[1.0.0]: https://github.com/bakame-php/spec/releases/tag/1.0.0