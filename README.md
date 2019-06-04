# Laravel Invoice

[![Build Status](https://img.shields.io/travis/artisanry/Invoice/master.svg?style=flat-square)](https://travis-ci.org/artisanry/Invoice)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/artisanry/invoice.svg?style=flat-square)]()
[![Latest Version](https://img.shields.io/github/release/artisanry/Invoice.svg?style=flat-square)](https://github.com/artisanry/Invoice/releases)
[![License](https://img.shields.io/packagist/l/artisanry/Invoice.svg?style=flat-square)](https://packagist.org/packages/artisanry/Invoice)

## Installation

Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

``` bash
$ composer require artisanry/invoice
```

## Usage

``` php
$faker = faker();

$vendor = new Vendor([
    'name' => $faker->name,
    'address' => $faker->streetAddress,
    'city' => $faker->city,
    'country' => $faker->country,
    'phone' => $faker->phoneNumber,
    'email' => $faker->email,
]);

$owner = new Owner([
    'name' => $faker->name,
    'address' => $faker->streetAddress,
    'city' => $faker->city,
    'country' => $faker->country,
    'phone' => $faker->phoneNumber,
    'email' => $faker->email,
]);

$products = new ProductCollection([
    [
        'sku' => '5168834966240078',
        'name' => 'Kristoffer Brown',
        'quantity' => 1,
        'unit_price' => '92,10 €',
        'total' => '92,10 €',
    ]
]);

$transaction = new Transaction([
    'id' => $faker->word,
    'subtotal' => 9210,
    'discount' => 0,
    'delivery' => 350,
    'tax' => 0,
    'total' => 9560,
    'created_at' => Carbon\Carbon::now(),
]);

$invoice = new Invoice($vendor, $owner, $products, $transaction);
$invoice->useLocale('en_US');
$invoice->useCurrency('USD');
$invoice->useView('receipt');

$invoice->view();
// $invoice->download();
```

## Testing

``` bash
$ phpunit
```

## Security

If you discover a security vulnerability within this package, please send an e-mail to hello@basecode.sh. All security vulnerabilities will be promptly addressed.

## Credits

- [Brian Faust](https://github.com/faustbrian)
- [All Contributors](../../contributors)

## License

[MIT](LICENSE) © [Brian Faust](https://basecode.sh)
