<?php

namespace App\Http\Services;
use App\Repositories\ShopRepository;
class ShopService
{

    private $shopRepository;

    public function __construct(ShopRepository $shopRepository)
    {
        $this->shopRepository = $shopRepository;
    }

     /**
    * Get shop by id.
    *
    * @param integer $shopId
    * @return array
    */
    public function getAllProduct()
    {
        return $this->shopRepository->getAllProduct();
    }

    /**
    * Get shop by id.
    *
    * @param integer $shopId
    * @return array
    */
    public function getShopById($shopId)
    {
        return $this->shopRepository->getProductByShopId($shopId);
    }
}
