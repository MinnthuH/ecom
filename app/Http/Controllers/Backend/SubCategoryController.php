<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    // ALL SUB CATEGORY METHOD
    public function AllSubCategory()
    {
        $subcategories = SubCategory::latest()->get();
        return view('backend.subcategory.all_subcategory', compact('subcategories'));
    } // End Method

    // Add SUBCATEGORY METHOD
    public function AddSubCategory()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        return view('backend.subcategory.add_subcategory', compact('categories'));
    } // End Method

    // STORE SUBCATEGORY METHOD
    public function StoreSubCategory(Request $request)
    {

        // validation
        $request->validate([
            'subcategory_name' => 'required',
        ]);

        // store data
        $subcategory = new SubCategory();
        $subcategory->category_id = $request->subcategory_id;
        $subcategory->subcategory_name = $request->subcategory_name;
        $subcategory->subcategory_slug = strtolower(str_replace('', '-', $request->subcategory_name));
        $subcategory->save();

        //notification
        $noti = array(
            'message' => 'SubCategory Added Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('all.subcategory')->with($noti);

    } // END METHOD

    // EDIT SUBCATEGORY METHOD
    public function EditSubCategory($id)
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $subcategory = SubCategory::findOrFail($id);

        return view('backend.subcategory.edit_subcategory', compact('subcategory', 'categories'));
    } // END METHOD

    // Update SubCategory Method
    public function UpdateSubCategory(Request $request)
    {
        $sub_id = $request->id;

        // validation
        $request->validate([
            'subcategory_name'=> 'required|unique:sub_categories'
        ]);

        // update data
        $sub_cat = SubCategory::findOrFail($sub_id);
        // dd($sub_cat);
        $sub_cat->category_id = $request->category_id;
        $sub_cat->subcategory_name = $request->subcategory_name;
        $sub_cat->subcategory_slug = strtolower(str_replace('', '-', $request->subcategory_name));
        $sub_cat->update();


        //notification
        $noti = array(
            'message' => 'SubCategory UpdatedSuccessfully',
            'alert-type' => 'success',
        );
        return redirect()->route('all.subcategory')->with($noti);

    }// End Method

     // DELETE SUB CATEGROY METHOD
     public function DeleteSubCategory($id)
     {
         // delete data
         SubCategory::findOrFail($id)->delete();

         $noti = array(
             'message' => 'SubCategory Delete Successfully',
             'alert-type' => 'success',
         );
         return redirect()->route('all.subcategory')->with($noti);

     }// END METHOD
}
