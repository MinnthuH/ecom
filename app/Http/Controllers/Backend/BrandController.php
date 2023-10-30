<?php

namespace App\Http\Controllers\Backend;

use App\Models\Brand;
use Image;
use App\Http\Controllers\Controller;
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
        $image =$request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension(); // 1234.jpg
        Image::make($image)->resize(300,300)->save('upload/brand/'.$name_gen);
        $save_url = 'upload/brand/'.$name_gen;

        // store data
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = strtolower(str_replace('','-',$request->name));
        $brand->image = $save_url;
        $brand->save();

        //notification
        $noti = array(
            'message' => 'Brand Added Successfully',
            'alert-type' => 'success',
        );
       return redirect()->route('all.brand')->with($noti);

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

        if($request->file('image')){
             // image name crate /resize and upload
        $image =$request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension(); // 1234.jpg
        Image::make($image)->resize(300,300)->save('upload/brand/'.$name_gen);
        $save_url = 'upload/brand/'.$name_gen;

        if(file_exists($old_img)){
            unlink($old_img);
        }

        // store data
        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
        $brand->slug = strtolower(str_replace('','-',$request->name));
        $brand->image = $save_url;
        $brand->update();

        //notification
        $noti = array(
            'message' => 'Brand Updated With Image Successfully',
            'alert-type' => 'success',
        );
       return redirect()->route('all.brand')->with($noti);

        }else{
            $brand = Brand::findOrFail($id);
            $brand->name = $request->name;
            $brand->slug = strtolower(str_replace('','-',$request->name));
            $brand->update();

            //notification
            $noti = array(
                'message' => 'Brand Updated without Image Successfully',
                'alert-type' => 'success',
            );
           return redirect()->route('all.brand')->with($noti);
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

        $noti = array(
            'message' => 'Brand Delete Successfully',
            'alert-type' => 'success',
        );
       return redirect()->route('all.brand')->with($noti);

    }// END METHOD
}
