<?php

namespace BrianFaust\Invoice;

if (!function_exists('formatter')) {
    function formatter()
    {
        return new Formatter(config('invoice.locale'), config('invoice.currency'));
    }
}
