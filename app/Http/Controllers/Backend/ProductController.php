<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MultiImg;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Image;

class ProductController extends Controller
{
    // All Product Method
    public function AllProduct()
    {
        $products = Product::latest()->get();
        return view('backend.product.product_all', compact('products'));

    } // End Method

    // Add Product Method
    public function AddProduct()
    {

        $activeVendor = User::where('status', 'active')
            ->where('role', 'vendor')->latest()->get();
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        return view('backend.product.add_product', compact('brands', 'categories', 'subcategories', 'activeVendor'));
    } // End Method

    // Store Product Method
    public function StoreProduct(Request $request)
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
            'product_slug' => strtolower(str_replace('', '-', $request->product_name)),
            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags' => $request->product_tags,
            'product_size' => $request->product_size,
            'product_color' => $request->product_color,
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,
            'product_thambnail' => $save_url,
            'vendor_id' => $request->vendor_id,
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

        return redirect()->route('all.product');

    } // End Method

    // Edit Product Method
    public function EditProduct($id)
    {
        $multiImages = MultiImg::where('product_id', $id)->get();
        $activeVendor = User::where('status', 'active')
            ->where('role', 'vendor')->latest()->get();
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        $products = Product::findOrFail($id);
        return view('backend.product.edit_product', compact('brands', 'categories', 'subcategories', 'activeVendor', 'products', 'multiImages'));

    } // End Method

    // Update Product Method
    public function UpdateProduct(Request $request)
    {
        // dd($request->toArray());
        $product_id = $request->id;

        Product::findOrFail($product_id)->update([

            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace('', '-', $request->product_name)),
            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags' => $request->product_tags,
            'product_size' => $request->product_size,
            'product_color' => $request->product_color,
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,
            'vendor_id' => $request->vendor_id,
            'hot_deals' => (int) $request->hot_deals,
            'featured' => (int) $request->featured,
            'special_offer' => (int) $request->special_offer,
            'special_deals' => (int) $request->special_deals,
            'status' => 1,

        ]);
        //notification
        toastr()->success('Product Update Without Image Successfully');

        return redirect()->route('all.product');
    } // /End Method

    // Update Product Thambnail
    public function UpdateProductThambnail(Request $request)
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
        return redirect()->route('all.product');
    } // End Method

    // Update Product Multi Image
    public function UpdateProductMultiimage(Request $request)
    {
        //validation
        $request->validate([
            'multi_img' => 'required',
        ]);

        $imags = $request->multi_img;
        foreach ($imags as $id => $img) {
            $imgDel = MultiImg::findOrFail($id);
            if (file_exists($imgDel->photo_name)) {
                unlink($imgDel->photo_name);
            }
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

    //Delete MultiImage Method
    public function DeleteMultiImages($id)
    {
        $oldImage = MultiImg::findOrFail($id);
        unlink($oldImage->photo_name);

        MultiImg::findOrFail($id)->delete();

        //notification
        toastr()->success('Product Multi Image Delete Successfully');
        return redirect()->back();

    } // End Method

    // Prodcut Inactive Method
    public function ProdcutInactive($id)
    {
        Product::findOrfail($id)->update([
            'status' => 0,

        ]);
        //notification
        toastr()->warning('Product Inactive');
        return redirect()->back();

    } //End Method

    // Prodcut Active Method
    public function ProdcutActive($id)
    {
        Product::findOrfail($id)->update([
            'status' => 1,

        ]);
        //notification
        toastr()->success('Product Active');
        return redirect()->back();

    } //End Method

    //Delete Product Method
    public function DeleteProduct($id)
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