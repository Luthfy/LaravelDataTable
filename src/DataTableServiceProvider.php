<?php

namespace Octopy\DataTable;

use Illuminate\Support\ServiceProvider;

final class DataTableServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands(DataTableCommand::class);
        }
    }
}
