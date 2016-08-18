## Installation

The Evernote cloud Service Provider can be installed via [Composer](http://getcomposer.org) by requiring the
`ishannz/silverstripe-evernote` package and setting the `minimum-stability` to `dev` (required for SilverStripe 3.1) in your
project's `composer.json`.

```json
{
    "require": {
        "ishannz/silverstripe-evernote": "dev-master"
    },
    "minimum-stability": "dev"
}
```

or

Require this package with composer:
```
composer require ishannz/silverstripe-evernote
```
Update your `composer.json` file to include this package as a dependency

Update your packages with ```composer update``` or install with ```composer install```.

In Windows, you'll need to include the GD2 DLL `php_gd2.dll` as an extension in php.ini.


## How to use
After configuration, you should just be able to visit evernote-auth/login using web-browser to initiate the Evernote Authenticate process.