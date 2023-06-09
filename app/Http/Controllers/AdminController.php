<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    // Admin Dashboard
    public function adminDashboard(){
        return view('admin.index');
    } // End Of Admin Dashboard


    // Admin Login
    public function adminLogin(){
        return view('admin.admin_login');
    } // End Of Admin Login


    // Admin Logout
    public function adminDestroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    } // End Of Admin Logout

    // Admin Profile
    public function adminProfile(){
        $id= Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_porfileview',compact('adminData'));
    } // End Of Admin Profile

    // Admin Profile Store
    public function adminProfileStore(Request $request){
        $id = Auth::user()->id;
        $data = User::find($id); // find user data with id

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if($request->file('photo')){
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/'.$data->photo)); // unlink old photo
            $fileName = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$fileName);
            $data['photo'] = $fileName;
        }
        $data->save();
        $notification = array(
            'message' => 'Profile Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    } // End Of Admin Profile Store

    // Admin Change Password
    public function adminChangePassword(){

        return view('admin.admin_change_password');
    } // End Of Admin Change Password

    // Admin Update Password
    public function adminUpdatePassword(Request $request){
        // dd($request->all());
        // Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'new_password_comfimation' => 'required|same:new_password',
        ]);

        // Match The Old Password With The Database
        if(!Hash::check($request->old_password, Auth::user()->password)){
            return back()->with('error','Old Password Does Not Match');
        }

        // Update The New Password
        User::whereId(Auth::user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);
        return back()->with('status','Password Updated Successfully');

    } // End Of Admin Update Password

}
