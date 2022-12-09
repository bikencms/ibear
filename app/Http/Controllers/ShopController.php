<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Services\ShopService;

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
        $products = $this->shopService->getAllProduct();
        return view('shop', [ 'products' => $products ]);
    }

    public function shop($id) {
        $products = $this->shopService->getShopById($id);
        return view('shop', [ 'products' => $products ]);
    }
}
