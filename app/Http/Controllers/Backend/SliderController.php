<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Image;

class SliderController extends Controller
{
    // ALL CATEGORY METHOD
    public function AllSlider()
    {
        $sliders = Slider::latest()->get();
        return view('backend.slider.all_slider', compact('sliders'));
    } // End Method

    // Add Slider METHOD
    public function AddSlider()
    {
        return view('backend.slider.add_slider');
    } // End Method

    // STORE SLIDER METHOD
    public function StoreSlider(Request $request)
    {

        // validation
        $request->validate([
            'slider_title' => 'required',
            'short_title' => 'required',
        ]);

        // image name crate /resize and upload
        $image = $request->file('slider_image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension(); // 1234.jpg
        Image::make($image)->resize(2376, 807)->save('upload/slider/' . $name_gen);
        $save_url = 'upload/slider/' . $name_gen;

        // store data
        $slider = new Slider();
        $slider->slider_title = $request->slider_title;
        $slider->short_title = $request->short_title;
        $slider->slider_image = $save_url;
        $slider->save();

        //notification
        toastr()->success('Category Added Successfully');

        return redirect()->route('all.slider');

    } // END METHOD

    // EDIT Slider METHOD
    public function EditSlider($id)
    {
        $slider = Slider::findOrFail($id);

        return view('backend.slider.edit_slider', compact('slider'));
    } // END METHOD

    // UPDATE  Slider METHOD
    public function UpdateSlider(Request $request)
    {
        $id = $request->id;
        $old_img = $request->old_image;

        if ($request->file('slider_image')) {
            // image name crate /resize and upload
            $image = $request->file('slider_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension(); // 1234.jpg
            Image::make($image)->resize(2376, 807)->save('upload/slider/' . $name_gen);
            $save_url = 'upload/slider/' . $name_gen;

            if (file_exists($old_img)) {
                unlink($old_img);
            }

            // store data
            $slider = Slider::findOrFail($id);
            $slider->slider_title = $request->slider_title;
            $slider->short_title = $request->short_title;
            $slider->slider_image = $save_url;
            $slider->update();

            //notification
            toastr()->success('Slider Updated With Image Successfully');

            return redirect()->route('all.slider');

        } else {
            $slider = Slider::findOrFail($id);
            $slider->slider_title = $request->slider_title;
            $slider->short_title = $request->short_title;
            $slider->update();

            //notificationa
            toastr()->success('Slider Updated Without Image Successfully');

            return redirect()->route('all.slider');
        } // end esle
    } // END METHOD

    // DELETE Slider METHOD
    public function DeleteSlider($id)
    {
        $slider = Slider::findOrFail($id);
        $img = $slider->slider_image;
        unlink($img);

        // delete data
        Slider::findOrFail($id)->delete();

        //notificationa
        toastr()->success('Category Delete Successfully');

        return redirect()->route('all.slider');

    } // END METHOD

}
