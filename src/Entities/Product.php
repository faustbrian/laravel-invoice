<?php

declare(strict_types=1);

/*
 * This file is part of Laravel Invoice.
 *
 * (c) Brian Faust <hello@brianfaust.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Invoice\Entities;

class Product
{
    /** @var \Illuminate\Support\Collection */
    private $data;

    /** @var string */
    private $sku;

    /** @var string */
    private $name;

    /** @var string */
    private $quantity;

    /** @var string */
    private $price;

    /** @var string */
    private $total;

    /**
     * Create a new product instance.
     */
    public function __construct(array $data)
    {
        $this->sku = array_get($data, 'sku');
        $this->name = array_get($data, 'name');
        $this->quantity = array_get($data, 'quantity');
        $this->price = array_get($data, 'price');
        $this->total = array_get($data, 'total');
        $this->meta = array_get($data, 'meta');
    }

    /**
     * Get the price that was paid (or will be paid).
     *
     * @return string
     */
    public function price()
    {
        return formatter()->formatAmount($this->price);
    }

    /**
     * Get the raw price that was paid (or will be paid).
     *
     * @return float
     */
    public function rawPrice()
    {
        return formatter()->formatDecimal($this->price);
    }

    /**
     * Get the total amount that was paid (or will be paid).
     *
     * @return string
     */
    public function total()
    {
        return formatter()->formatAmount($this->total);
    }

    /**
     * Get the raw total amount that was paid (or will be paid).
     *
     * @return float
     */
    public function rawTotal()
    {
        return formatter()->formatDecimal($this->total);
    }

    /*
     * Dynamically get values from the product instance.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->{$key};
    }
}
