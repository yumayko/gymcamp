<?php

namespace App\Repositories\Contracts;

interface SubscribePackageRepositoryInterface
{
    public function getAllSubcribePackage();

    public function find($id);

    public function getPrice($subscribePackageId);
}