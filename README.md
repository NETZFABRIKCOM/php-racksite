NETZAFBRIK racksite api
=======================

## Installing php-racksite via composer

Now you can install "netzfabrik/php-racksite" via composer
```bash
php composer.phar require "netzfabrik/php-racksite"
```

## Use
```php
  $racksite = new \NETZFABRIK\racksite\racksiteApi('username@sso.racksite.net', 'client-secret');
  dump($racksite->getColobootPxeInstaller());
```
