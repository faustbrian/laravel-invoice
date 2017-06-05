<?php

/*
 * This file is part of Laravel Invoice.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Invoice\Entities;

use BrianFaust\Invoice\ProductCollection;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class Invoice
{
    /** @var \BrianFaust\Invoice\Vendor */
    protected $vendor;

    /** @var \BrianFaust\Invoice\Owner */
    protected $owner;

    /** @var \BrianFaust\Invoice\ProductCollection */
    protected $products;

    /** @var \BrianFaust\Invoice\Transaction */
    protected $transaction;

    /**
     * Create a new invoice instance.
     *
     * @param \BrianFaust\Invoice\Vendor            $vendor
     * @param \BrianFaust\Invoice\Owner             $owner
     * @param \BrianFaust\Invoice\ProductCollection $products
     * @param \BrianFaust\Invoice\Transaction       $transaction
     */
    public function __construct(Vendor $vendor, Owner $owner, ProductCollection $products, Transaction $transaction)
    {
        $this->vendor = $vendor;
        $this->owner = $owner;
        $this->products = $products;
        $this->transaction = $transaction;

        $this->useLocale(config('laravel-invoice.locale'));
        $this->useCurrency(config('laravel-invoice.currency'));
        $this->useView(config('laravel-invoice.view'));
    }

    /**
     * Set the locale to be used when formatting currency.
     *
     * @param string $locale
     */
    public function useLocale(string $locale)
    {
        config(['invoice.locale' => $locale]);
    }

    /**
     * Set the currency to be used when formatting currency.
     *
     * @param string $currency
     */
    public function useCurrency(string $currency)
    {
        config(['invoice.currency' => $currency]);
    }

    /**
     * Set the view to be used when rendering the pdf.
     *
     * @param string $view
     */
    public function useView(string $view)
    {
        config(['invoice.view' => $view]);
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
        return $this->transaction->date($timezone);
    }

    /**
     * Get the total of the invoice (before discounts).
     *
     * @return string
     */
    public function subtotal()
    {
        return $this->transaction->subtotal();
    }

    /**
     * Get the raw total of the invoice (before discounts).
     *
     * @return float
     */
    public function rawSubtotal()
    {
        return $this->transaction->rawSubtotal();
    }

    /**
     * Get the delivery cost of the invoice.
     *
     * @return string
     */
    public function delivery()
    {
        return $this->transaction->delivery();
    }

    /**
     * Get the raw delivery cost of the invoice.
     *
     * @return float
     */
    public function rawDelivery()
    {
        return $this->transaction->rawDelivery();
    }

    /**
     * Get the tax of the invoice.
     *
     * @return string
     */
    public function tax()
    {
        return $this->transaction->tax();
    }

    /**
     * Get the raw tax of the invoice.
     *
     * @return float
     */
    public function rawTax()
    {
        return $this->transaction->rawTax();
    }

    /**
     * Get the total amount that was paid (or will be paid).
     *
     * @return string
     */
    public function total()
    {
        return $this->transaction->total();
    }

    /**
     * Get the raw total amount that was paid (or will be paid).
     *
     * @return float
     */
    public function rawTotal()
    {
        return $this->transaction->rawTotal();
    }

    /**
     * Get the discount amount.
     *
     * @return string
     */
    public function discount()
    {
        return formatter()->formatAmount($this->transaction->discount);
    }

    /**
     * Get the raw discount amount.
     *
     * @return string
     */
    public function rawDiscount()
    {
        return formatter()->formatDecimal($this->transaction->discount);
    }

    /**
     * Get the View instance for the invoice.
     *
     * @param array $data
     *
     * @return \Illuminate\View\View
     */
    public function view()
    {
        return View::make(config('laravel-invoice.view'), [
            'invoice' => $this,
            'vendor' => $this->vendor,
            'owner' => $this->owner,
            'products' => $this->products,
            'transaction' => $this->transaction,
        ]);
    }

    /**
     * Capture the invoice as a PDF and return the raw bytes.
     *
     * @param array $data
     *
     * @return string
     */
    public function pdf()
    {
        if (!defined('DOMPDF_ENABLE_AUTOLOAD')) {
            define('DOMPDF_ENABLE_AUTOLOAD', false);
        }

        if (file_exists($configPath = base_path().'/vendor/dompdf/dompdf/dompdf_config.inc.php')) {
            require_once $configPath;
        }

        $dompdf = new Dompdf();

        $dompdf->loadHtml($this->view()->render());

        $dompdf->render();

        return $dompdf->output();
    }

    /**
     * Create an invoice download response.
     *
     * @param array $data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function download()
    {
        $filename = $this->transaction->id.'_'.$this->date()->month.'_'.$this->date()->year.'.pdf';

        return new Response($this->pdf(), 200, [
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            'Content-Transfer-Encoding' => 'binary',
            'Content-Type' => 'application/pdf',
        ]);
    }

    /**
     * Dynamically get values from the transaction.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->transaction->{$key};
    }
}
