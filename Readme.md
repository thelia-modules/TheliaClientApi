# Thelia Client Api

This module is under development. This is a PHP client for Thelia API.

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is TheliaClientApi.
* Activate it in your thelia administration panel

### Composer

Add it in your main thelia composer.json file

```
composer require thelia/thelia-api-module:dev-master
```

## Usage

Create an instance of ```TheliaClientApi\Classes\Client``` with the following parameters :

```php
$client = new TheliaClientApi\Classes\Client("my api token", "my api key", "http://mysite.tld");
```

Or, if u have set the default parameters in the module configuration :

```php
$client = new TheliaClientApi\Classes\Client();
```

You can access to your resources by using the 'do*' methods

```php
<?php
list($status, $data) = $client->doList("products");
list($status, $data) = $client->doGet("products/1/image", 1);
list($status, $data) = $client->doPost("products", ["myData"]);
list($status, $data) = $client->doPut("products", ["myData"]);
list($status, $data) = $client->doDelete("products", 1);
```
