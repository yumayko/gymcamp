<?php

namespace App\Providers;

use App\Repositories\GymRepository;
use App\Repositories\CityRepository;
use App\Repositories\BookingRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\GymRepositoryInterface;
use App\Repositories\Contracts\CityRepositoryInterface;
use App\Repositories\Contracts\BookingRepositoryInterface;
use App\Repositories\Contracts\subscribePackageRepositoryInterface;
use App\Repositories\subscribePackageRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CityRepositoryInterface::class, CityRepository::class);
        $this->app->singleton(GymRepositoryInterface::class, GymRepository::class);
        $this->app->singleton(BookingRepositoryInterface::class, BookingRepository::class);
        $this->app->singleton(subscribePackageRepositoryInterface::class, subscribePackageRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
