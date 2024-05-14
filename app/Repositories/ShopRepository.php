<?php

namespace App\Repositories;
use App\Models\Product;
use Carbon\Carbon;
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

    public function getAllProduct($date = null)
    {
        if ( $date != null ) {
            $dt = Carbon::createFromFormat('Y-m-d H:i:s', $date);
            $dt = new Carbon($dt->toDateString());
            $zeroHourDate = $dt->toDateTimeString();
            return $this->model
                    ->select([
                        'products.*', 'users.name as user_name'
                    ])
                    ->whereDate('products.created_at', $zeroHourDate)
                    ->leftJoin('users', 'users.id', '=', 'user_id')
                    ->orderBy('products.created_at', 'DESC')
                    ->paginate(12);
        } else {
            return $this->model
                    ->select([
                        'products.*', 'users.name as user_name'
                    ])
                    ->leftJoin('users', 'users.id', '=', 'user_id')
                    ->orderBy('products.created_at', 'DESC')
                    ->paginate(12);
        }
       
        
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
