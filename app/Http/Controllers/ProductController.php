<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LastModified;
class ProductController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $redirect = '/dashboard/product';
    public function index() {
        $products = Product::paginate(20);
        return view('dashboard.product.index', [ 'products' => $products]); 
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
            'name' => 'required|max:30',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);

        if ($request->isMethod('post')) {
            $image =  time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads'), $image);
            $newProduct = Product::create([
                "name" => $request->input('name'),
                "image" => $image,
                "price" => $request->input('price'),
                "user_id" => Auth::id(),
                "is_public" => 0
            ]);

            if(!is_null($newProduct)) {
                LastModified::set($newProduct->created_at);
                return back()->with('success','Success! product uploaded');
            } else {
                return back()->with("failed", "Alert! product not uploaded");
            }
        }
    }
}
