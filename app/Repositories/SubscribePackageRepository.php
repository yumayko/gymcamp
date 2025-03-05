<?php

namespace App\Repositories;

use App\Models\SubscribePackage;
use App\Repositories\Contracts\subscribePackageRepositoryInterface;

class SubscribePackageRepository implements SubscribePackageRepositoryInterface
{
    public function getAllSubcribePackage()
    {
        return SubscribePackage::orderBy('id', 'asc')->get();
    }

    public function find($id)
    {
        return SubscribePackage::find($id);
    }

    public function getPrice($subscribePackageId)
    {
        $subscribePackage = $this->find($subscribePackageId);
        return $subscribePackage ? $subscribePackage->price : 0;
    }
}