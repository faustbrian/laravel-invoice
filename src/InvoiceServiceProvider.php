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

use BrianFaust\ServiceProvider\AbstractServiceProvider;

class InvoiceServiceProvider extends AbstractServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(): void
    {
        $this->publishConfig();

        $this->publishViews();

        $this->loadViews();
    }

    /**
     * Register bindings in the container.
     */
    public function register(): void
    {
        parent::register();

        $this->mergeConfig();
    }

    /**
     * Register package name.
     */
    protected function getPackageName()
    {
        return 'invoice';
    }
}
