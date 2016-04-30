<?php

namespace Cheapest\Http\Controllers\Api\V1;

use Cheapest\Http\Controllers\Controller;
use Cheapest\Http\Requests;
use Cheapest\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Construct the controller instance with dependency
     * injection for the product model.
     *
     * @param Product $products
     */
    public function __construct(Product $products)
    {
        $this->products = $products;
    }

    public function index()
    {
        return $this->products->paginate(50);
        //return $this->products->all();
    }

    public function search(Request $request)
    {
        $name = $request->input('q');
        return $this->products->search($name)->orderBy('price', 'asc')->paginate(15);
    }
}
