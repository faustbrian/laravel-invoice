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

use Carbon\Carbon;

class Transaction
{
    /** @var string */
    private $id;

    /** @var float */
    private $subtotal;

    /** @var float */
    private $discount;

    /** @var float */
    private $delivery;

    /** @var float */
    private $tax;

    /** @var float */
    private $total;

    /** @var \DateTime */
    private $createdAt;

    /** @var \Illuminate\Support\Collection */
    private $meta;

    /**
     * Create a new transaction instance.
     */
    public function __construct(array $data)
    {
        $this->id = array_get($data, 'id');
        $this->subtotal = array_get($data, 'subtotal');
        $this->discount = array_get($data, 'discount');
        $this->delivery = array_get($data, 'delivery');
        $this->tax = array_get($data, 'tax');
        $this->total = array_get($data, 'total');
        $this->createdAt = array_get($data, 'created_at');
        $this->meta = array_get($data, 'meta');
    }

    /**
     * Get the total of the invoice (before discounts).
     *
     * @return string
     */
    public function subtotal()
    {
        return formatter()->formatAmount($this->subtotal);
    }

    /**
     * Get the raw total of the invoice (before discounts).
     *
     * @return float
     */
    public function rawSubtotal()
    {
        return formatter()->formatDecimal($this->subtotal);
    }

    /**
     * Get the discount amount.
     *
     * @return string
     */
    public function discount()
    {
        return formatter()->formatAmount($this->discount);
    }

    /**
     * Get the raw discount amount.
     *
     * @return string
     */
    public function rawDiscount()
    {
        return formatter()->formatDecimal($this->discount);
    }

    /**
     * Get the delivery cost of the invoice.
     *
     * @return string
     */
    public function delivery()
    {
        return formatter()->formatAmount($this->delivery);
    }

    /**
     * Get the raw delivery cost of the invoice.
     *
     * @return float
     */
    public function rawDelivery()
    {
        return formatter()->formatDecimal($this->delivery);
    }

    /**
     * Get the tax of the invoice.
     *
     * @return string
     */
    public function tax()
    {
        return formatter()->formatAmount($this->tax);
    }

    /**
     * Get the raw tax of the invoice.
     *
     * @return float
     */
    public function rawTax()
    {
        return formatter()->formatDecimal($this->tax);
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

    /**
     * Get a Carbon date for the invoice.
     *
     * @param \DateTimeZone|string $timezone
     *
     * @return \Carbon\Carbon
     */
    public function date($timezone = null)
    {
        $carbon = Carbon::instance($this->createdAt);

        return $timezone ? $carbon->setTimezone($timezone) : $carbon;
    }

    /**
     * Dynamically get values from the transaction instance.
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
