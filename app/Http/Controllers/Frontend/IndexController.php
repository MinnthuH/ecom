<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MultiImg;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Symfony\Component\HttpFoundation\Request;

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
        $color = $product->product_color;
        $product_color = explode(',', $color);

        $size = $product->product_size;
        $product_size = explode(',', $size);

        $catId = $product->category_id;
        $relatedProduct = Product::where('category_id', $catId)->where('id', '!=', $id)->orderBy('id', 'DESC')->limit(4)->get();

        $multiImg = MultiImg::where('product_id', $id)->get();

        return view('frontend.product.product_details', compact('product', 'product_color', 'product_size', 'multiImg', 'relatedProduct'));
    } // End Product Deatil Method

    // Vendor Details Method
    public function VendorDetails($id)
    {

        $vendor = User::findOrFail($id);
        $vendorProduct = Product::where('vendor_id', $id)->get();

        return view('frontend.vendor.vendor_details', compact('vendor', 'vendorProduct'));
    } // End Vendor Details Method

    // All Vendor Method
    public function VendorAll()
    {

        $vendors = User::where('status', 'active')
            ->where('role', 'vendor')
            ->orderBy('id', 'DESC')
            ->get();
        return view('frontend.vendor.vendor_all', compact('vendors'));
    } // End Vendor All Method

    // Category Prouduct Method

    public function CatWiseProduct(Request $request, $id, $slug)
    {
        $products = Product::where('status', 1)->where('category_id', $id)->orderBy('id', 'DESC')->get();

        $categories = Category::orderBy('name', 'ASC')->get();

        $breadcat = Category::where('id', $id)->first();

        $newProduct = Product::orderBy('id', 'DESC')->limit(3)->get();

        return view('frontend.product.category_view', compact('products', 'categories', 'breadcat', 'newProduct'));
    } // End Category Product Method

    // SubCategory Prouduct Method

    public function SubCatWiseProduct(Request $request, $id, $slug)
    {
        $products = Product::where('status', 1)->where('subcategory_id', $id)->orderBy('id', 'DESC')->get();

        $subcategories = SubCategory::orderBy('subcategory_name', 'ASC')->get();

        $breadcat = SubCategory::where('id', $id)->first();

        $newProduct = Product::orderBy('id', 'DESC')->limit(3)->get();

        return view('frontend.product.subcategory_view', compact('products', 'subcategories', 'breadcat', 'newProduct'));
    } // End Category Product Method

    // Product View Ajax Method
    public function ProdcutViewAjax($id)
    {
        $product = Product::with('category', 'brand')->findOrFail($id);

        $color = $product->product_color;
        $product_color = explode(',', $color);

        $size = $product->product_size;
        $product_size = explode(',', $size);

        return response()->json([
            'product' => $product,
            'color' => $product_color,
            'size' => $product_size,
        ]);
    }
}