<?php

namespace App\Repositories;
use App\Models\Product;
class ShopRepository
{

    protected $model;

    /**
     * ShopRepository constructor.
     * @param Order $order
     */
    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    public function getAllProduct()
    {
        return $this->model
                    ->select([
                        'products.*', 'users.name as user_name'
                    ])
                    ->leftJoin('users', 'users.id', '=', 'user_id')->paginate(12);
    }

    public function getProductByShopId($shopId)
    {
        return $this->model
                    ->select([
                        'products.*', 'users.name as user_name'
                    ])
                    ->leftJoin('users', 'users.id', '=', 'user_id')
                    ->where('user_id', $shopId)->paginate(12);
    }

}
