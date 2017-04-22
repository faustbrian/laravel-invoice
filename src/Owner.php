<?php

/*
 * This file is part of Laravel Invoice.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Invoice;

class Owner
{
    /** @var string */
    private $name;

    /** @var string */
    private $address;

    /** @var string */
    private $city;

    /** @var string */
    private $country;

    /** @var string */
    private $phone;

    /** @var string */
    private $email;

    /**
     * Create a new owner instance.
     */
    public function __construct(array $data)
    {
        $this->name = array_get($data, 'name');
        $this->address = array_get($data, 'address');
        $this->city = array_get($data, 'city');
        $this->country = array_get($data, 'country');
        $this->phone = array_get($data, 'phone');
        $this->email = array_get($data, 'email');
        $this->meta = array_get($data, 'meta');
    }

    /**
     * Dynamically get values from the meta data.
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
