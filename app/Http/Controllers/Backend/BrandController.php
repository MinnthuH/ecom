<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;

class BrandController extends Controller
{
    // ALL BRAND METHOD
    public function AllBrand()
    {
        $brands = Brand::latest()->get();
        return view('backend.brand.all_brands', compact('brands'));
    } // End Method


    // Add BRADN METHOD

    public function AddBrand()
    {
        return view('backend.brand.add_brand');
    } // End Method
}
