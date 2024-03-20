<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Image;

class BannerController extends Controller
{
    // ALL CATEGORY METHOD
    public function AllBanner()
    {
        $banners = Banner::latest()->get();
        return view('backend.banner.all_banner', compact('banners'));
    } // End Method

    // Add Banner METHOD
    public function AddBanner()
    {
        return view('backend.banner.add_banner');
    } // End Method

    // STORE SLIDER METHOD
    public function StoreBanner(Request $request)
    {

        // validation
        $request->validate([
            'banner_title' => 'required',
            'banner_url' => 'required',
        ]);

        // image name crate /resize and upload
        $image = $request->file('banner_image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension(); // 1234.jpg
        Image::make($image)->resize(768, 450)->save('upload/banner/' . $name_gen);
        $save_url = 'upload/banner/' . $name_gen;

        // store data
        $banner = new Banner();
        $banner->banner_title = $request->banner_title;
        $banner->banner_url = $request->banner_url;
        $banner->banner_image = $save_url;
        $banner->save();

        //notification
        toastr()->success('Banner Added Successfully');

        return redirect()->route('all.banner');

    } // END METHOD

    // EDIT BANNER METHOD
    public function EditBanner($id)
    {
        $banner = Banner::findOrFail($id);

        return view('backend.banner.edit_banner', compact('banner'));
    } // END METHOD

    // UPDATE  Banner METHOD
    public function UpdateBanner(Request $request)
    {
        $id = $request->id;
        $old_img = $request->old_image;

        if ($request->file('banner_image')) {
            // image name crate /resize and upload
            $image = $request->file('banner_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension(); // 1234.jpg
            Image::make($image)->resize(768, 450)->save('upload/banner/' . $name_gen);
            $save_url = 'upload/banner/' . $name_gen;

            if (file_exists($old_img)) {
                unlink($old_img);
            }

            // store data
            $banner = Banner::findOrFail($id);
            $banner->banner_title = $request->banner_title;
            $banner->banner_url = $request->banner_url;
            $banner->banner_image = $save_url;
            $banner->update();

            //notification
            toastr()->success('Banner Updated With Image Successfully');

            return redirect()->route('all.banner');

        } else {
            $banner = Banner::findOrFail($id);
            $banner->banner_title = $request->banner_title;
            $banner->banner_url = $request->banner_url;
            $banner->update();

            //notificationa
            toastr()->success('Banner Updated Without Image Successfully');

            return redirect()->route('all.banner');
        } // end esle
    } // END METHOD

    // DELETE Slider METHOD
    public function DeleteBanner($id)
    {
        $banner = Banner::findOrFail($id);
        $img = $banner->banner_image;
        unlink($img);

        // delete data
        Banner::findOrFail($id)->delete();

        //notificationa
        toastr()->success('Banner Delete Successfully');

        return redirect()->route('all.banner');

    } // END METHOD

}
