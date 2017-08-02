# Laravel Invoice

## Installation

Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

``` bash
$ composer require faustbrian/laravel-invoice
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

If you discover a security vulnerability within this package, please send an e-mail to Brian Faust at hello@brianfaust.me. All security vulnerabilities will be promptly addressed.

## Credits

- [Brian Faust](https://github.com/faustbrian)
- [All Contributors](../../contributors)

## License

[MIT](LICENSE) © [Brian Faust](https://brianfaust.me)
