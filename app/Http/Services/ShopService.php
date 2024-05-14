<?php

namespace App\Http\Services;
use App\Repositories\ShopRepository;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Collection;
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
    public function getAllProduct($date = null)
    {
        return $this->shopRepository->getAllProduct($date);
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
