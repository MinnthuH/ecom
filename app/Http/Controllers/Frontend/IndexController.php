<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\MultiImg;
use App\Models\Product;

class IndexController extends Controller
{
    //Product Detail Method
    public function ProductDetails($id, $slug)
    {
        $product = Product::findOrFail($id);
        $color = $product->prodcut_color;
        $product_color = explode(',', $color);

        $size = $product->prodcut_size;
        $prodcut_size = explode(',', $size);

        $catId = $product->category_id;
        $relatedProduct = Product::where('category_id', $catId)->where('id', '!=', $id)->orderBy('id', 'DESC')->limit(4)->get();

        $multiImg = MultiImg::where('product_id', $id)->get();

        return view('frontend.product.product_details', compact('product', 'product_color', 'prodcut_size', 'multiImg', 'relatedProduct'));
    }
}
