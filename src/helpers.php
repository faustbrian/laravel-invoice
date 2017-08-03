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

namespace BrianFaust\Invoice;

if (! function_exists('formatter')) {
    function formatter()
    {
        return new Formatter(config('invoice.locale'), config('invoice.currency'));
    }
}
