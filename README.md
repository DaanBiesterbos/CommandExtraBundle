Command Extra Bundle
==========
[![Build CommandExtraBundle](https://github.com/DaanBiesterbos/CommandExtraBundle/actions/workflows/build.yaml/badge.svg)](https://github.com/DaanBiesterbos/CommandExtraBundle/actions/workflows/build.yaml)
[![Latest Stable Version](https://poser.pugx.org/daanbiesterbos/command-extra-bundle/v/stable.svg)](https://packagist.org/packages/daanbiesterbos/command-extra-bundle)
[![Total Downloads](https://poser.pugx.org/daanbiesterbos/command-extra-bundle/downloads.svg)](https://packagist.org/packages/daanbiesterbos/command-extra-bundle)



## Installation


This bundle is available on Packagist. You can install it using Composer.

```bash
composer require daanbiesterbos/command-extra-bundle
```

### Step 2: Enable the bundle

Add the bundle to *config/bundles.php*

```php
return [
    DaanBiesterbos\CommandExtraBundle\CommandExtraBundle::class => ['all' => true],
];
```

### Step 3: Configure the bundle

Finally, configure the bundle:

``` yaml
# config/packages/command_extra.yaml
command_extra:
  aliases:
    # Shorthand to update the master branch.
    checkout:
      name: 'ps'
      description: 'Shorthand example to run a non symfony command'
      execute: 'ps -aux'
    cache_purge:
      name: 'cache:purge'
      description: 'Prune cache pools and application cache.'
      execute:
        cache_pool:
          command: 'cache:pool:prune'
          symfony: true
        app_cache:
          command: 'cache:clear'
          symfony: true
```
