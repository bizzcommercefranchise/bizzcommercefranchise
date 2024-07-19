<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Domains\Product\Services\ProductService;
use App\Domains\Franchise\Services\FranchiseService;
use App\Domains\Login\Services\LoginService;
use App\Domains\Product\Interfaces\ProductServiceInterface;
use App\Domains\Login\Interfaces\LoginServiceInterface;
use App\Domains\Franchise\Interfaces\FranchiseServiceInterface;
use App\Domains\Product\Models\Product;
use App\Domains\Franchise\Models\Franchise;
use App\Domains\Login\Models\Users;
use App\Domains\Provider\Models\Providers;
use App\Domains\Provider\Interfaces\ProviderServiceInterface;
use App\Domains\Provider\Interfaces\ProviderUserServiceInterface;
use App\Domains\Provider\Interfaces\LocationServiceInterface;
use App\Domains\Provider\Services\ProviderService;
use App\Domains\Provider\Services\ProviderUserService;
use App\Domains\Provider\Services\LocationService;
use App\Domains\Provider\Models\ProviderUsers;
use App\Domains\Provider\Models\Locations;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductServiceInterface::class, function () {
            return new ProductService(new Product);
        });
        $this->app->bind(FranchiseServiceInterface::class, function () {
            return new FranchiseService(new Franchise);
        });        
        $this->app->bind(LoginServiceInterface::class, function () {
            return new LoginService(new Users);
        });
        $this->app->bind(ProviderServiceInterface::class, function () {
            return new ProviderService(new Providers);
        });
        $this->app->bind(ProviderUserServiceInterface::class, function () {
            return new ProviderUserService(new ProviderUsers);
        });
        $this->app->bind(LocationServiceInterface::class, function () {
            return new LocationService(new Locations);
        });        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         View::addNamespace('auth', base_path('app/resources/views/auth'));
         View::addNamespace('product', base_path('app/Domains/Product/resources/views'));
    }
}
