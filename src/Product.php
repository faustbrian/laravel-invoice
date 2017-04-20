<?php

namespace BrianFaust\Invoice;

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
    private $unit_price;

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
        $this->unitPrice = array_get($data, 'unit_price');
        $this->total = array_get($data, 'total');
        $this->meta = array_get($data, 'meta');
    }

    /**
     * Get the unit price that was paid (or will be paid).
     *
     * @return string
     */
    public function unitPrice()
    {
        return formatter()->formatAmount($this->unitPrice);
    }

    /**
     * Get the raw unit price that was paid (or will be paid).
     *
     * @return float
     */
    public function rawUnitPrice()
    {
        return formatter()->formatDecimal($this->unitPrice);
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
