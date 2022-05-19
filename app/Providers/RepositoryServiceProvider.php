<?php

namespace App\Providers;

use App\Contracts\Admin\Attribute\AttributeContract;
use App\Contracts\Admin\Brand\BrandContract;
use App\Contracts\Admin\Category\CategoryContract;
use App\Contracts\Admin\Product\ProductContract;
use App\Repositories\Admin\Attribute\AttributeRepository;
use App\Repositories\Admin\Brand\BrandRepository;
use App\Repositories\Admin\Category\CategoryRepository;
use App\Repositories\Admin\Product\ProductRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [

        CategoryContract::class => CategoryRepository::class,
        AttributeContract::class => AttributeRepository::class,
        BrandContract::class => BrandRepository::class,
        ProductContract::class => ProductRepository::class,

    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $interface => $implementation) {
            $this->app->bind($interface,$implementation);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
