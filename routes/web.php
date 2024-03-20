<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Middleware\RedirectIfAuthenticated;
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
Route::get('/admin/login', [AdminController::class, 'adminLogin'])->middleware(RedirectIfAuthenticated::class)->name('admin.login'); // Admin Login
/////////Vendor Login /////////////
Route::get('/vendor/login', [VendorController::class, 'vendorLogin'])->middleware(RedirectIfAuthenticated::class)->name('vendor.login'); // Vendor Login

Route::get('/become/vendor', [VendorController::class, 'BecomeVendor'])->name('become.vendor'); // Become Vendor
Route::post('/vendor/register', [VendorController::class, 'VendorRegister'])->name('vendor.register'); // Vendor Register

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

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

    // VENDOR PRODUCT ALL ROUTE
    Route::controller(VendorProductController::class)->group(function () {
        Route::get('/vendor/all/product', 'VendorAllProduct')->name('vendor.all.product'); // Vender All Route
        Route::get('/vendor/add/product', 'VendorAddProduct')->name('vendor.add.product'); // Vender add Route
        Route::get('vendor/subcategory/ajax/{id}', 'VendorGetSubCategory'); // Vendor ajax call
        Route::post('/vendor/store/product', 'VendorStoreProduct')->name('vendor.store.product'); // Vender store Route
        Route::get('/vendor/edit/product/{id}', 'VendorEditProduct')->name('vendor.edit.product'); // Vendor Edit Prodcut Route
        Route::post('/vendor/update/product', 'VendorUpadateProduct')->name('vendor.update.product'); // Vendor update product Route
        Route::post('/vendor/update/product/thambnail', 'VendorUpadateProductThambnail')->name('vendor.update.product.thambnail'); // Vendor update product Route

        Route::post('/vendor/update/product/multiimage', 'VendorUpadateProductMultiImage')->name('vendor.update.product.multiimage'); // Vendor update product Route
        Route::get('vendor/product/multiimage/delete/{id}', 'VendorDeleteMultiImages')->name('vendor.product.multiimage.delete'); // Vendor Delete Product MultiImage
        Route::get('/vendor/product/inactive/{id}', 'VendorProdcutInactive')->name('vendor.product.inactive'); // Vendor Product Inactive
        Route::get('/vendor/product/active/{id}', 'VendorProdcutActive')->name('vendor.product.active'); // Vendor Product Active
        Route::get('/vendor/delete/product/{id}', 'VendorDeleteProduct')->name('vendor.delete.product'); // Delete Product

    });
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    // BRAND ALL ROUTE
    Route::controller(BrandController::class)->group(function () {
        Route::get('/all/barnd', 'AllBrand')->name('all.brand'); // All Brand Route
        Route::get('/add/barnd', 'AddBrand')->name('add.brand'); // Add Brand Route
        Route::post('/store/brand', 'StoreBrand')->name('store.brand'); // Store Brand Route
        Route::get('/edit/brand/{id}', 'EditBrand')->name('edit.brand'); // Edit Brand Route
        Route::post('/update/brand', 'UpdateBrand')->name('update.brand'); // Update Brand Route
        Route::get('/delete/brand/{id}', 'DeleteBrand')->name('delete.brand'); // Delete Brand Route
        Route::get('/edit/brand/{id}', 'EditBrand')->name('edit.brand'); // Edit Brand Route

    });

    // CATEGORY ALL ROUTE
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/all/category', 'AllCategory')->name('all.category'); // All Category Route
        Route::get('/add/category', 'AddCategory')->name('add.category'); // Add Category Route
        Route::post('/store/category', 'StoreCategory')->name('store.category'); // Store Brand Route
        Route::get('/edit/category/{id}', 'EditCategory')->name('edit.category'); // Edit Category Route
        Route::post('/update/category', 'UpdateCategory')->name('update.category'); // Update Category Route
        Route::get('/delete/category/{id}', 'DeleteCategory')->name('delete.category'); // Delete Category Route

    });

    // SUB CATEGORY ALL ROUTE
    Route::controller(SubCategoryController::class)->group(function () {
        Route::get('/all/subcategory', 'AllSubCategory')->name('all.subcategory'); // All SubCategory Route
        Route::get('/add/subcategory', 'AddSubCategory')->name('add.subcategory'); // Add SubCategory Route
        Route::post('/store/subcategory', 'StoreSubCategory')->name('store.subcategory'); // Store SubCategory Route
        Route::get('/edit/subcategory/{id}', 'EditSubCategory')->name('edit.subcategory'); // Edit SubCategory Route
        Route::post('/update/subcategory', 'UpdateSubCategory')->name('update.subcategory'); // Update SubCategory Route
        Route::get('/delete/subcategory/{id}', 'DeleteSubCategory')->name('delete.subcategory'); // Delete SubCategory Route
        Route::get('/subcategory/ajax/{id}', 'GetSubCategory'); // ajax call

    });

    // VENDOR ACTIVE AND INACTIVE ROUTE
    Route::controller(AdminController::class)->group(function () {
        Route::get('/inactive-vendor', 'InactiveVendor')->name('inactive.vendor'); // Inactvie vendor route
        Route::get('/active-vendor', 'ActiveVendor')->name('active.vendor'); // Actvie vendor route
        Route::get('/inactive-vendor/detail/{id}', 'InactiveVendorDetail')->name('inactive.vendor.detail'); // Inactive Vendor Detail
        Route::post('/inactive-vendor/approve', 'ActiveVendorApprove')->name('active.vendor.approve'); // Active Vendor Approve
        Route::get('/active-vendor/detail/{id}', 'ActiveVendorDetail')->name('active.vendor.detail'); // Active Vendor Detail
        Route::post('/active-vendor/approve', 'InactiveVendorApprove')->name('inactive.vendor.approve'); // Inactive Vendor Approve
    });

    // PRODUCT ALL ROUTE
    Route::controller(ProductController::class)->group(function () {
        Route::get('/all/product', 'AllProduct')->name('all.product'); // All Prodcut Route
        Route::get('/add/product', 'AddProduct')->name('add.product'); // Add Prodcut Route
        Route::post('/store/product', 'StoreProduct')->name('store.product'); // Store Prodcut Route
        Route::get('/edit/product/{id}', 'EditProduct')->name('edit.product'); // Edit Prodcut Route
        Route::post('/update/product', 'UpdateProduct')->name('update.product'); // Update Prodcut Route
        Route::post('/update/product/thambnail', 'UpdateProductThambnail')->name('update.product.thambnail'); //Update Product Image
        Route::post('/update/product/multiimage', 'UpdateProductMultiimage')->name('update.product.multiimage'); //Update Product Multiimage
        Route::get('/product/multiimage/delete/{id}', 'DeleteMultiImages')->name('product.multiimage.delete'); // Delete MultiImages
        Route::get('/product/inactive/{id}', 'ProdcutInactive')->name('product.inactive'); // Product Inactive
        Route::get('/product/active/{id}', 'ProdcutActive')->name('product.active'); // Product active
        Route::get('/delete/product/{id}', 'DeleteProduct')->name('delete.product'); // Delete Product

    });

    // Slider ALL ROUTE
    Route::controller(SliderController::class)->group(function () {
        Route::get('/all/slider', 'AllSlider')->name('all.slider'); // All Slider Route
        Route::get('/add/slider', 'AddSlider')->name('add.slider'); // Add Slider Route
        Route::post('/store/slider', 'StoreSlider')->name('store.slider'); // Store Slider Route
        Route::get('/edit/slider/{id}', 'EditSlider')->name('edit.slider'); // Edit Slider Route
        Route::post('/update/slider', 'UpdateSlider')->name('update.slider'); // Update Slider Route
        Route::get('/delete/slider/{id}', 'DeleteSlider')->name('delete.slider'); // Delete Slider Route

    });

    // Banner ALL ROUTE
    Route::controller(BannerController::class)->group(function () {
        Route::get('/all/banner', 'AllBanner')->name('all.banner'); // All Banner Route
        Route::get('/add/banner', 'AddBanner')->name('add.banner'); // Add Banner Route
        Route::post('/store/banner', 'StoreBanner')->name('store.banner'); // Store Banner Route
        Route::get('/edit/banner/{id}', 'EditBanner')->name('edit.banner'); // Edit Banner Route
        Route::post('/update/banner', 'UpdateBanner')->name('update.banner'); // Update Banner Route
        Route::get('/delete/banner/{id}', 'DeleteBanner')->name('delete.banner'); // Delete Banner Route

    });
});

require __DIR__ . '/auth.php';
