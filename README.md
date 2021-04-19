Command Extra Bundle
==========
[![Build CommandExtraBundle](https://github.com/DaanBiesterbos/CommandExtraBundle/actions/workflows/build.yaml/badge.svg?branch=main)](https://github.com/DaanBiesterbos/CommandExtraBundle/actions/workflows/build.yaml)
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
    # Example 1:
    # Register alias to run a non symfony command.
    ps:
      name: 'ps'
      description: 'Shorthand example of a non symfony command.'
      execute: 'ps -aux'  # This shorthand is for non-symfony commands only.
    # Example 2
    # Register alias that runs two symfony commands when invoked.
    cache_purge:
      name: 'cache:purge'
      description: 'Prune cache pools and application cache.'
      execute:
        # Run multiple commands 
        cache_pool:
          command: 'cache:pool:prune'
          symfony: true
        app_cache:
          command: 'cache:clear'
          symfony: true
```
