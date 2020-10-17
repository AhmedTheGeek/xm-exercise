<?php

namespace App\Providers;

use App\Repositories\Stock\HistoricalRepository;
use App\Repositories\Stock\StockRepository;
use App\Repositories\Symbol\SymbolRepository;
use App\Repositories\Symbol\SymbolDefinitionRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {

    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        $this->app->bind( StockRepository::class, HistoricalRepository::class );
        $this->app->bind( SymbolRepository::class, SymbolDefinitionRepository::class );
    }

}
