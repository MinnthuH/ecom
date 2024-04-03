<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MultiImg;
use App\Models\Product;

class IndexController extends Controller
{

    // Index Page Method
    public function Index()
    {
        $skipCategory0 = Category::skip(0)->first();
        $skipPorduct0 = Product::where('status', 1)->where('category_id', $skipCategory0->id)->orderBy('id', 'DESC')->limit(5)->get();

        $skipCategory2 = Category::skip(2)->first();
        $skipPorduct2 = Product::where('status', 1)->where('category_id', $skipCategory2->id)->orderBy('id', 'DESC')->limit(5)->get();

        $skipCategory4 = Category::skip(4)->first();
        $skipPorduct4 = Product::where('status', 1)->where('category_id', $skipCategory4->id)->orderBy('id', 'DESC')->limit(5)->get();

        $hot_deals = Product::where('hot_deals', 1)->where('discount_price', '!=', null)->orderBy('id', 'DESC')->limit(5)->get();

        $special_offer = Product::where('special_offer', 1)->orderBy('id', 'DESC')->limit(5)->get();

        $special_deals = Product::where('special_deals', 1)->orderBy('id', 'DESC')->limit(5)->get();

        $news = Product::where('status', 1)->orderBy('id', 'DESC')->limit(3)->get();

        return view('frontend.index', compact('skipCategory0', 'skipPorduct0', 'skipCategory2', 'skipPorduct2', 'skipCategory4', 'skipPorduct4', 'hot_deals', 'special_offer', 'special_deals', 'news'));
    }

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