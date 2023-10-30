<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;

class CategoryController extends Controller
{
     // ALL BRAND METHOD
     public function AllCategory()
     {
         $categories = Category::latest()->get();
         return view('backend.category.all_category', compact('categories'));
     } // End Method


     // Add CATEGORY METHOD
    public function AddCategory()
    {
        return view('backend.category.add_category');
    } // End Method


    // STORE CATEGORY METHOD
    public function StoreCategory(Request $request)
    {

         // validation
         $request->validate([
            'name' => 'required',
        ]);

        // image name crate /resize and upload
        $image =$request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension(); // 1234.jpg
        Image::make($image)->resize(300,300)->save('upload/category/'.$name_gen);
        $save_url = 'upload/category/'.$name_gen;

        // store data
        $brand = new Category();
        $brand->name = $request->name;
        $brand->slug = strtolower(str_replace('','-',$request->name));
        $brand->image = $save_url;
        $brand->save();

        //notification
        $noti = array(
            'message' => 'Category Added Successfully',
            'alert-type' => 'success',
        );
       return redirect()->route('all.category')->with($noti);

    } // END METHOD

     // EDIT CATEGORY METHOD
     public function EditCategory($id)
     {
         $category = Category::findOrFail($id);

         return view('backend.category.edit_category', compact('category'));
     } // END METHOD

     // UPDATE  CATEGORY METHOD
    public function UpdateCategory(Request $request)
    {
        $id = $request->id;
        $old_img = $request->old_image;

        if($request->file('image')){
             // image name crate /resize and upload
        $image =$request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension(); // 1234.jpg
        Image::make($image)->resize(300,300)->save('upload/category/'.$name_gen);
        $save_url = 'upload/category/'.$name_gen;

        if(file_exists($old_img)){
            unlink($old_img);
        }

        // store data
        $brand = Category::findOrFail($id);
        $brand->name = $request->name;
        $brand->slug = strtolower(str_replace('','-',$request->name));
        $brand->image = $save_url;
        $brand->update();

        //notification
        $noti = array(
            'message' => 'Category Updated With Image Successfully',
            'alert-type' => 'success',
        );
       return redirect()->route('all.category')->with($noti);

        }else{
            $brand = Category::findOrFail($id);
            $brand->name = $request->name;
            $brand->slug = strtolower(str_replace('','-',$request->name));
            $brand->update();

            //notification
            $noti = array(
                'message' => 'CategoryUpdated without Image Successfully',
                'alert-type' => 'success',
            );
           return redirect()->route('all.category')->with($noti);
        } // end esle
    } // END METHOD

    // DELETE CATEGROY METHOD
    public function DeleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $img = $category->image;
        unlink($img);

        // delete data
        Category::findOrFail($id)->delete();

        $noti = array(
            'message' => 'Category Delete Successfully',
            'alert-type' => 'success',
        );
       return redirect()->route('all.category')->with($noti);

    }// END METHOD

}
