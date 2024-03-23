<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MultiImg;
use App\Models\Product;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;

class VendorProductController extends Controller
{
    // Vendro All Product Method
    public function VendorAllProduct()
    {
        $id = Auth::user()->id;
        $products = Product::where('vendor_id', $id)->latest()->get();
        return view('vendor.backend.product.vendor_all_product', compact('products'));

    } // End Method

    // Vendor Add Product Method
    public function VendorAddProduct()
    {

        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        return view('vendor.backend.product.vendor_add_product', compact('brands', 'categories', 'subcategories'));
    } // End Method

    // ajax call method
    public function VendorGetSubCategory($category_id)
    {

        $subcat = SubCategory::where('category_id', $category_id)->orderBy('subcategory_name', 'ASC')->get();
        return json_encode($subcat);

    } // End Method

    // Vendor Store Prodcut Method
    public function VendorStoreProduct(Request $request)
    {

        // image name crate /resize and upload
        $image = $request->file('product_thumbnail');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension(); // 1234.jpg
        Image::make($image)->resize(1100, 1100)->save('upload/products/thumbnail/' . $name_gen);
        $save_url = 'upload/products/thumbnail/' . $name_gen;

        $product_id = Product::insertGetId([

            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace('', '-', $request->name)),
            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags' => $request->product_tags,
            'prodcut_size' => $request->prodcut_size,
            'prodcut_color' => $request->prodcut_color,
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,
            'product_thambnail' => $save_url,
            'vendor_id' => Auth::user()->id,
            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals,
            'status' => 1,
            'created_at' => Carbon::now()->setTimezone('Asia/Yangon'),
        ]);

        // Multiple Image Upload ////

        $images = $request->file('multi_img');
        if ($images) {
            foreach ($images as $img) {
                $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension(); // 1234.jpg
                Image::make($img)->resize(1100, 1100)->save('upload/products/multi-image/' . $make_name);
                $uploadPath = 'upload/products/multi-image/' . $make_name;

                MultiImg::insert([
                    'product_id' => $product_id,
                    'photo_name' => $uploadPath,
                    'created_at' => Carbon::now()->setTimezone('Asia/Yangon'),
                ]);
            } // End foreach
        }

        //notification
        toastr()->success('Product Inserted Successfully');

        return redirect()->route('vendor.all.product');

    } // End Method

    //Vendor Edit Product Method
    public function VendorEditProduct($id)
    {
        $multiImages = MultiImg::where('product_id', $id)->get();
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        $products = Product::findOrFail($id);
        return view('vendor.backend.product.vendor_edit_product', compact('brands', 'categories', 'subcategories', 'products', 'multiImages'));

    } // End Method

    // Vendor Update Product Method
    public function VendorUpadateProduct(Request $request)
    {
        $product_id = $request->id;

        Product::findOrFail($product_id)->update([

            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace('', '-', $request->name)),
            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags' => $request->product_tags,
            'prodcut_size' => $request->prodcut_size,
            'prodcut_color' => $request->prodcut_color,
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,
            'hot_deals' => (int) $request->hot_deals,
            'featured' => (int) $request->featured,
            'special_offer' => (int) $request->special_offer,
            'special_deals' => (int) $request->special_deals,
            'status' => 1,

        ]);
        //notification
        toastr()->success('Product Update Without Image Successfully');

        return redirect()->route('vendor.all.product');
    } // /End Method

    // Vendor Update Product Thambnail
    public function VendorUpadateProductThambnail(Request $request)
    {
        // dd($request->toArray());
        $pro_id = $request->id;
        $oldImage = $request->old_img;

        $image = $request->file('product_thambnail');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalName(); // 1234.jpg
        Image::make($image)->resize(800, 800)->save('upload/products/thumbnail/' . $name_gen);
        $save_url = 'upload/products/thumbnail/' . $name_gen;

        if (file_exists($oldImage)) {
            unlink($oldImage);
        }

        Product::findOrFail($pro_id)->update([
            'product_thambnail' => $save_url,
            'updated_at' => Carbon::now()->setTimezone('Asia/Yangon'),
        ]);
        //notification
        toastr()->success('Product Thambnail Update Successfully');
        return redirect()->route('vendor.all.product');
    } // End Method

    // Update Product Multi Image
    public function VendorUpadateProductMultiImage(Request $request)
    {
        //validation
        $request->validate([
            'multi_img' => 'required',
        ]);

        $imags = $request->multi_img;
        foreach ($imags as $id => $img) {
            $imgDel = MultiImg::findOrFail($id);
            unlink($imgDel->photo_name);
            $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension(); // 1234.jpg
            Image::make($img)->resize(800, 800)->save('upload/products/multi-image/' . $make_name);
            $uploadPath = 'upload/products/multi-image/' . $make_name;
            MultiImg::where('id', $id)->update([
                'photo_name' => $uploadPath,
                'updated_at' => Carbon::now()->setTimezone('Asia/Yangon'),
            ]);
        } // end foreach

        //notification
        toastr()->success('Product Multi Image Update Successfully');
        return redirect()->back();
    } // End Method

    //Vendor Delete MultiImage Method
    public function VendorDeleteMultiImages($id)
    {
        $oldImage = MultiImg::findOrFail($id);
        unlink($oldImage->photo_name);

        MultiImg::findOrFail($id)->delete();

        //notification
        toastr()->success('Product Multi Image Delete Successfully');
        return redirect()->back();

    } // End Method

    // Vendor Prodcut Inactive Method
    public function VendorProdcutInactive($id)
    {
        Product::findOrfail($id)->update([
            'status' => 0,

        ]);
        //notification
        toastr()->warning('Product Inactive');
        return redirect()->back();

    } //End Method

    // Vendor Prodcut Active Method
    public function VendorProdcutActive($id)
    {
        Product::findOrfail($id)->update([
            'status' => 1,

        ]);
        //notification
        toastr()->success('Product Active');
        return redirect()->back();

    } //End Method

    //Delete Product Method
    public function VendorDeleteProduct($id)
    {
        $product = Product::findOrFail($id);
        unlink($product->product_thambnail);
        Product::findOrFail($id)->delete();

        // delete multi image and unlink mutiImage
        $multiImages = MultiImg::where('product_id', $id)->get();
        if ($multiImages) {
            foreach ($multiImages as $img) {
                unlink($img->photo_name);
                MultiImg::where('product_id', $id)->delete();
            }
        }
        //notification
        toastr()->success('Product Delete Successfully');
        return redirect()->back();

    } // End Method

}
