<?php

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
