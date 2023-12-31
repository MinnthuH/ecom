<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'UserDashboard'])->name('user.dashboard'); // User dahboard
    Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile-store'); // User Profile Store
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout'); // User logout
    Route::post('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update'); // User Profile Store

}); // Group Middleware End

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

/////////Admin Login /////////////
Route::get('/admin/login', [AdminController::class, 'adminLogin'])->name('admin.login'); // Admin Login
/////////Vendor Login /////////////
Route::get('/vendor/login', [VendorController::class, 'vendorLogin'])->name('vendor.login'); // Vendor Login

Route::get('/become/vendor', [VendorController::class, 'BecomeVendor'])->name('become.vendor'); // Become Vendor
Route::post('/vendor/register',[VendorController::class,'VendorRegister'])->name('vendor.register'); // Vendor Register



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

/////////////////////// ADMIN DASHBOARD //////////////////////////
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard'); // Admin dahboard
    Route::get('/admin/logout', [AdminController::class, 'adminDestroy'])->name('admin.logout'); // Admin Logout
    Route::get('/admin/profile', [AdminController::class, 'adminProfile'])->name('admin.profile'); // Admin Profile
    Route::post('/admin/profile/store', [AdminController::class, 'adminProfileStore'])->name('admin.profile-store'); // Admin Profile Store
    Route::get('/admin/change-password', [AdminController::class, 'adminChangePassword'])->name('admin.change-password'); // Admin Change Password
    Route::post('/admin/update-password', [AdminController::class, 'adminUpdatePassword'])->name('update.password'); // Admin Update Password')
});

/////////////////////// VENDOR DASHBOARD //////////////////////////
Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor/dashboard', [VendorController::class, 'vendorDashboard'])->name('vendor.dashboard'); // vendor dahboard
    Route::get('/vendor/logout', [VendorController::class, 'vendorDestroy'])->name('vendor.logout'); // vendor Logout
    Route::get('/vendor/profile', [VendorController::class, 'vendorProfile'])->name('vendor.profile'); // vendor Profile view
    Route::post('/vendor/profile/store', [VendorController::class, 'vendorProfileStore'])->name('vendor.profile-store'); // vendor Profile Store
    Route::get('/vendor/change-password', [VendorController::class, 'vendorChangePassword'])->name('vendor.change-password'); // Vendor Change Password view
    Route::post('/vendor/update-password', [VendorController::class, 'vendorUpdatePassword'])->name('vendor-update.password'); // Vendor Update Password

});


Route::middleware(['auth', 'role:admin'])->group(function () {
    // BRAND ALL ROUTE
    Route::controller(BrandController::class)->group(function () {
        Route::get('/all/barnd', 'AllBrand')->name('all.brand'); // All Brand Route
        Route::get('/add/barnd', 'AddBrand')->name('add.brand'); // Add Brand Route
        Route::post('/store/brand','StoreBrand')->name('store.brand'); // Store Brand Route
        Route::get('/edit/brand/{id}','EditBrand')->name('edit.brand'); // Edit Brand Route
        Route::post('/update/brand','UpdateBrand')->name('update.brand'); // Update Brand Route
        Route::get('/delete/brand/{id}','DeleteBrand')->name('delete.brand'); // Delete Brand Route
        Route::get('/edit/brand/{id}','EditBrand')->name('edit.brand'); // Edit Brand Route

    });

    // CATEGORY ALL ROUTE
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/all/category', 'AllCategory')->name('all.category'); // All Category Route
        Route::get('/add/category', 'AddCategory')->name('add.category'); // Add Category Route
        Route::post('/store/category','StoreCategory')->name('store.category'); // Store Brand Route
        Route::get('/edit/category/{id}','EditCategory')->name('edit.category'); // Edit Category Route
        Route::post('/update/category','UpdateCategory')->name('update.category'); // Update Category Route
        Route::get('/delete/category/{id}','DeleteCategory')->name('delete.category'); // Delete Category Route

    });

     // SUB CATEGORY ALL ROUTE
     Route::controller(SubCategoryController::class)->group(function () {
        Route::get('/all/subcategory', 'AllSubCategory')->name('all.subcategory'); // All SubCategory Route
        Route::get('/add/subcategory', 'AddSubCategory')->name('add.subcategory'); // Add SubCategory Route
        Route::post('/store/subcategory','StoreSubCategory')->name('store.subcategory'); // Store SubCategory Route
        Route::get('/edit/subcategory/{id}','EditSubCategory')->name('edit.subcategory'); // Edit SubCategory Route
        Route::post('/update/subcategory','UpdateSubCategory')->name('update.subcategory'); // Update SubCategory Route
        Route::get('/delete/subcategory/{id}','DeleteSubCategory')->name('delete.subcategory'); // Delete SubCategory Route')

    });

     // VENDOR ACTIVE AND INACTIVE ROUTE
     Route::controller(AdminController::class)->group(function () {
        Route::get('/inactive-vendor', 'InactiveVendor')->name('inactive.vendor'); // Inactvie vendor route
        Route::get('/active-vendor', 'ActiveVendor')->name('active.vendor'); // Actvie vendor route
        Route::get('/inactive-vendor/detail/{id}','InactiveVendorDetail')->name('inactive.vendor.detail'); // Inactive Vendor Detail
        Route::post('/inactive-vendor/approve','ActiveVendorApprove')->name('active.vendor.approve'); // Active Vendor Approve
        Route::get('/active-vendor/detail/{id}','ActiveVendorDetail')->name('active.vendor.detail'); // Active Vendor Detail
        Route::post('/active-vendor/approve','InactiveVendorApprove')->name('inactive.vendor.approve'); // Inactive Vendor Approve
    });
});
