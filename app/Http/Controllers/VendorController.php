<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class VendorController extends Controller
{
    // Vendor Login
    public function vendorLogin()
    {
        return view('vendor.vendor_login');
    } // End Of Vendor Login

    // Vendor Dashboard
    public function vendorDashboard()
    {
        return view('vendor.index');
    } // End Of vendor Dashboard

    // Vendor logout
    public function vendorDestroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/vendor/login');
    } // End Of Vendor logout

    // Vendor profile method
    public function vendorProfile()
    {
        $id = Auth::user()->id;
        $vendorData = User::find($id);
        return view('vendor.vendor_profile', compact('vendorData'));

    } // End Of Vendor profile method

    // Vendor profile update method
    public function vendorProfileStore(Request $request)
    {

        $id = Auth::user()->id;
        $data = User::find($id); // find user data with id

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->vendor_join = $request->vendor_join;
        $data->vendor_short_info = $request->vendor_short_info;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/vendor_images/' . $data->photo)); // unlink old photo
            $fileName = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/vendor_images'), $fileName);
            $data['photo'] = $fileName;
        }
        $data->save();
        $notification = array(
            'message' => 'Vendor Profile Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    } // End Of Vendor profile update method

    // Vendor change password Method
    public function vendorChangePassword()
    {
        return view('vendor.vendor_change_password');
    } // End Of Vendor Change Password

    // Vendor update password Method
    public function vendorUpdatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'new_password_comfimation' => 'required|same:new_password',
        ]);

        // Match The Old Password With The Database
        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return back()->with('error', 'Old Password Does Not Match');
        }

         // Update The New Password
         User::whereId(Auth::user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);
        return back()->with('status', 'Password Updated Successfully');

    } // End of Vendor update password Method


    // Become Vendor method
    public function BecomeVendor(){
        return view ('auth.become_vendor');
    } // End Become Vendor method

    // Vendor Register Method
    public function VendorRegister(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed'],
        ]);

        $user = User::insert([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'vendor_join' => $request->vendor_join,
            'password' => Hash::make($request->password),
            'role' => 'vendor',
            'status' => 'inactive',
        ]);

        $noti = array(
            'message' => 'Vendor Registered Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('vendor.login')->with($noti);
    }

}
