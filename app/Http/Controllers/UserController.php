<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    //User Dashboard Method
    public function UserDashboard()
    {
        $id = Auth::user()->id;
        $userData = User::find($id);
        return view('index', compact('userData'));
    } // End Method


    // PROFILE SOTRE METHOD
    public function UserProfileStore(Request $request){

        $id = Auth::user()->id;
        $data = User::find($id); // find user data with id

        $data->username = $request->username;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/user_images/' . $data->photo)); // unlink old photo
            $fileName = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/user_images'), $fileName);
            $data['photo'] = $fileName;
        }
        $data->save();
        $notification = array(
            'message' => 'Profile Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);

    } // END METHOD

    // USER LOGOUT METHOD

    public function UserLogout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $notification = array(
            'message' => 'User Logout Successfully',
            'alert-type' => 'success',
        );
        return redirect('/login')->with($notification);
    } // END METHOD

    // USER PASSWORD CHANGE METHOD
    public function UserPasswordUpdate(Request $request){

         // Validation
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

    } // END METHOD
}
