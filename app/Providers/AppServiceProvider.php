<?php

namespace App\Providers;

use Core\Product\Contracts\ProductRepositoryInterface;
use Core\Product\infrastructure\ProductRepository;
use Core\Sale\Contracts\SaleRepositoryInterface;
use Core\Sale\infrastructure\SaleRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(SaleRepositoryInterface::class, SaleRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
