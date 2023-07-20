[![MIT license](http://img.shields.io/badge/license-MIT-brightgreen.svg)](http://opensource.org/licenses/MIT)
[![Packagist](https://img.shields.io/packagist/v/flownative/workspacemodulespeedup.svg)](https://packagist.org/packages/flownative/workspacemodulespeedup)
[![Maintenance level: Friendship](https://img.shields.io/badge/maintenance-%E2%99%A1%E2%99%A1-ff69b4.svg)](https://www.flownative.com/en/products/open-source.html)

# Flownative.WorkspaceModuleSpeedUp

This package introduces a caching mechanism for the Neos workspace module which improves performance
for projects with many workspace and / or pending changes. The implementation overrides functionality
of the Neos core via AOP and this is only a preliminary solution until a similar mechanism has been
added to the official Neos releases.

## Installation

```bash
composer require 'flownative/workspacemodulespeedup:*@dev'
```
