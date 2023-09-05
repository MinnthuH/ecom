<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('frontend.index');
});


Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard',[UserController::class,'UserDashboard'])->name('user.dashboard'); // User dahboard

}); // Group Middleware End

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/////////////////////// ADMIN DASHBOARD //////////////////////////
Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/admin/dashboard',[AdminController::class,'adminDashboard'])->name('admin.dashboard'); // Admin dahboard
    Route::get('/admin/logout',[AdminController::class,'adminDestroy'])->name('admin.logout'); // Admin Logout
    Route::get('/admin/profile',[AdminController::class,'adminProfile'])->name('admin.profile'); // Admin Profile
    Route::post('/admin/profile/store',[AdminController::class,'adminProfileStore'])->name('admin.profile-store'); // Admin Profile Store
    Route::get('/admin/change-password',[AdminController::class,'adminChangePassword'])->name('admin.change-password'); // Admin Change Password
    Route::post('/admin/update-password',[AdminController::class,'adminUpdatePassword'])->name('update.password'); // Admin Update Password')
});

/////////////////////// VENDOR DASHBOARD //////////////////////////
Route::middleware(['auth','role:vendor'])->group(function () {
    Route::get('/vendor/dashboard',[VendorController::class,'vendorDashboard'])->name('vendor.dashboard'); // vendor dahboard
    Route::get('/vendor/logout',[VendorController::class,'vendorDestroy'])->name('vendor.logout'); // vendor Logout
    Route::get('/vendor/profile',[VendorController::class,'vendorProfile'])->name('vendor.profile'); // vendor Profile view
    Route::post('/vendor/profile/store',[VendorController::class,'vendorProfileStore'])->name('vendor.profile-store'); // vendor Profile Store
    Route::get('/vendor/change-password',[VendorController::class,'vendorChangePassword'])->name('vendor.change-password'); // Vendor Change Password view
    Route::post('/vendor/update-password',[VendorController::class,'vendorUpdatePassword'])->name('vendor-update.password'); // Vendor Update Password

});


/////////Admin Login /////////////
Route::get('/admin/login',[AdminController::class,'adminLogin'])->name('admin.login'); // Admin Login
/////////Vendor Login /////////////
Route::get('/vendor/login',[VendorController::class,'vendorLogin'])->name('vendor.login'); // Vendor Login
