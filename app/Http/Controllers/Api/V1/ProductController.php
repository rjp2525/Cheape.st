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

    public function search(Request $request)
    {
        if ($request->input('q') && !empty($request->input('q'))) {
            return $this->products->searchProducts($request->input('q'))->paginate(15)->appends(['q' => $request->input('q')]);
        }

        return response()->json(['error' => true, 'message' => 'No search query provided']);
    }

    public function detail($id)
    {
        $item = $this->products->find($id);
        if ($item) {
            return response()->json($this->products->find($id));
        }

        return response()->json(['error' => true, 'message' => 'No products found for item ID ' . e($id)]);
    }
}
