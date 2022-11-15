<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
class ProductController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $redirect = '/dashboard/product';
    public function index() {
        return view('dashboard.product.index'); 
    }

    public function add() {
        return view('dashboard.product.add'); 
    }

    /**
     * Store a new blog post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
        ]);

    }
}
