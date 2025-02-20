<?php

namespace App\Services;

use App\Repositories\Contracts\GymRepositoryInterface;
use App\Repositories\Contracts\CityRepositoryInterface;
use App\Repositories\Contracts\SubscribePackageRepositoryInterface;

class FrontService
{
    protected $gymRepository;
    protected $cityRepository;
    protected $subscribePackageRepository;

    public function __construct(CityRepositoryInterface $cityRepository, GymRepositoryInterface $gymRepository,
    SubscribePackageRepositoryInterface $subscribePackageRepository)
    {
        $this->gymRepository = $gymRepository;
        $this->cityRepository = $cityRepository;
        $this->subscribePackageRepository = $subscribePackageRepository;
    }

    public function getFrontPageData()
    {
        $cities = $this->cityRepository->getAllCities();
        $popularGyms = $this->gymRepository->getPopularGyms(4);
        $newsGyms = $this->gymRepository->getAllNewsGyms();
        
        return compact('cities', 'popularGyms', 'newsGyms');
    }

    public function getSubscriptionsData()
    {
        $subscribePackage = $this->subscribePackageRepository->getAllSubcribePackage();
        return compact('subscribePackage');
    }

}