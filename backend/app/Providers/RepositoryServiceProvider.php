<?php

namespace App\Providers;

use App\Repositories\Symbol\HistoricalRepository;
use App\Repositories\Symbol\SymbolRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SymbolRepository::class, HistoricalRepository::class);

    }

}
