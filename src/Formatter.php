<?php

/*
 * This file is part of Laravel Invoice.
 *
 * (c) Brian Faust <hello@brianfaust.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Invoice;

use Money\Money;
use Money\Currency;
use NumberFormatter;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Money\Formatter\DecimalMoneyFormatter;

class Formatter
{
    /**
     * The current currency.
     *
     * @var string
     */
    private $locale;

    /**
     * The current currency.
     *
     * @var string
     */
    private $currency;

    /**
     * The current currency symbol.
     *
     * @var string
     */
    private $currencySymbol;

    /**
     * Create a new owner instance.
     */
    public function __construct(string $locale, string $currency)
    {
        $this->locale = $locale;
        $this->currency = strtoupper($currency);
        $this->currencySymbol = $this->getCurrencySymbol($locale, $currency);
    }

    /**
     * Set the locale to be used when formatting currency.
     *
     * @param string $locale
     */
    public function useLocale(string $locale)
    {
        $this->locale = $locale;
    }

    /**
     * Get the locale currently in use.
     *
     * @return string
     */
    public function usesLocale(): string
    {
        return $this->locale;
    }

    /**
     * Set the currency to be used when billing models.
     *
     * @param string      $currency
     * @param string|null $symbol
     */
    public function useCurrency(string $currency, string $symbol = null)
    {
        $this->currency = $currency;

        $this->useCurrencySymbol($symbol ?: $this->getCurrencySymbol($currency));
    }

    /**
     * Get the currency currently in use.
     *
     * @return string
     */
    public function usesCurrency(): string
    {
        return $this->currency;
    }

    /**
     * Set the currency symbol to be used when formatting currency.
     *
     * @param string $symbol
     */
    public function useCurrencySymbol(string $symbol)
    {
        $this->currencySymbol = $symbol;
    }

    /**
     * Get the currency symbol currently in use.
     *
     * @return string
     */
    public function usesCurrencySymbol(): string
    {
        return $this->currencySymbol;
    }

    /**
     * Format the given amount into a displayable currency.
     *
     * @param string|float $amount
     *
     * @return string
     */
    public function formatAmount($amount): string
    {
        if (is_string($amount)) {
            $amount = $this->convertStringToDecimal($amount) * 100;
        }

        $money = $this->getMoneyInstance($amount);

        $numberFormatter = new NumberFormatter($this->locale, NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, new ISOCurrencies());

        return $moneyFormatter->format($money);
    }

    /**
     * Format the given amount into decimals.
     *
     * @param string|float $amount
     *
     * @return string
     */
    public function formatDecimal($amount): float
    {
        if (is_string($amount)) {
            $amount = $this->convertStringToDecimal($amount);
        }

        $moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        return (float) $moneyFormatter->format($this->getMoneyInstance($amount));
    }

    /**
     * Determine the currency symbol for the given currency.
     *
     * @param string|null $currency
     *
     * @return string
     */
    public function getCurrencySymbol(string $currency = null): string
    {
        // Create a NumberFormatter
        $formatter = new NumberFormatter($this->locale, NumberFormatter::CURRENCY);

        // Prevent any extra spaces, etc. in formatted currency
        $formatter->setPattern('¤');

        // Prevent significant digits (e.g. cents) in formatted currency
        $formatter->setAttribute(NumberFormatter::MAX_SIGNIFICANT_DIGITS, 0);

        // Get the formatted price for '0'
        $formattedPrice = $formatter->formatCurrency(0, $this->currency);

        // Strip out the zero digit to get the currency symbol
        $zero = $formatter->getSymbol(NumberFormatter::ZERO_DIGIT_SYMBOL);
        $currencySymbol = str_replace($zero, '', $formattedPrice);

        return $currencySymbol;
    }

    /**
     * Create a new Money instance.
     *
     * @param string|float $amount
     *
     * @return \Money\Money
     */
    private function getMoneyInstance($amount): Money
    {
        if ($amount instanceof Money) {
            return $amount;
        }

        return new Money($amount, new Currency($this->currency));
    }

    /**
     * Filter the numbers out of a string.
     *
     * @return \Money\Money
     */
    private function convertStringToDecimal(string $amount): float
    {
        return (float) filter_var($amount, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }
}
