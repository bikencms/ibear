<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Services\ShopService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class ShopController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $shopService;
    /**
     * Instantiate a new controller instance.
     *
     * @param \App\Http\Services\ShopService $shopService
     * @return void
     */
    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }

    public function index() {
        if( isset($_GET['date']) && $_GET['date'] != '' ) {
            $date = $_GET['date'];
            $date = Carbon::createFromFormat('d/m/Y', $date)->toDateTimeString();
        } else {
            $date = null;
        }

        if( isset($_GET['page']) && $_GET['page'] != '' ) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }

        if( Cache::has($page.'product_homepage'. $date)) {
            $products = Cache::get($page.'product_homepage'. $date);
        } else {
            $products = $this->shopService->getAllProduct($date);
            Cache::forever($page.'product_homepage'. $date, $products);
        }
        return view('shop.shop', [ 'products' => $products ]);
    }

    public function shop($id) {
        $products = $this->shopService->getShopById($id);
        return view('shop.shop', [ 'products' => $products ]);
        
    }
}
