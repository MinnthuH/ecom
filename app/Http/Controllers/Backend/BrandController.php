<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Image;
use Symfony\Component\HttpFoundation\Request;

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

    // STORE BRAND METHOD
    public function StoreBrand(Request $request)
    {

        // validation
        $request->validate([
            'name' => 'required',
        ]);

        // image name crate /resize and upload
        $image = $request->file('image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension(); // 1234.jpg
        Image::make($image)->resize(300, 300)->save('upload/brand/' . $name_gen);
        $save_url = 'upload/brand/' . $name_gen;

        // store data
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = strtolower(str_replace('', '-', $request->name));
        $brand->image = $save_url;
        $brand->save();

        //notification
        toastr()->success('Brand Added Successfully');

        return redirect()->route('all.brand');

    } // END METHOD

    // EDIT BRAND METHOD
    public function EditBrand($id)
    {
        $brand = Brand::findOrFail($id);

        return view('backend.brand.edit_brand', compact('brand'));
    } // END METHOD

    // UPDATE  BRAND METHOD
    public function UpdateBrand(Request $request)
    {
        $id = $request->id;
        $old_img = $request->old_image;

        if ($request->file('image')) {
            // image name crate /resize and upload
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension(); // 1234.jpg
            Image::make($image)->resize(300, 300)->save('upload/brand/' . $name_gen);
            $save_url = 'upload/brand/' . $name_gen;

            if (file_exists($old_img)) {
                unlink($old_img);
            }

            // store data
            $brand = Brand::findOrFail($id);
            $brand->name = $request->name;
            $brand->slug = strtolower(str_replace('', '-', $request->name));
            $brand->image = $save_url;
            $brand->update();

            //notification
            toastr()->success('Brand Updated With Image Successfully');

            return redirect()->route('all.brand');

        } else {
            $brand = Brand::findOrFail($id);
            $brand->name = $request->name;
            $brand->slug = strtolower(str_replace('', '-', $request->name));
            $brand->update();

            //notification
            toastr()->success('Brand Updated without Image Successfully');

            return redirect()->route('all.brand');

        } // end esle
    } // END METHOD

    // DELETE METHOD
    public function DeleteBrand($id)
    {
        $brand = Brand::findOrFail($id);
        $img = $brand->image;
        unlink($img);

        // delete data
        Brand::findOrFail($id)->delete();

        //notification
        toastr()->success('Brand Delete Successfully');

        return redirect()->route('all.brand');

    } // END METHOD
}
