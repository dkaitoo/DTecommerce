<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BrandsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ColorsController;
use App\Http\Controllers\Admin\DimensionController;
use App\Http\Controllers\Admin\MemoryController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\SellersController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\VolumeController;
use App\Http\Controllers\BotManController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ConfirmController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\RatingController;
use App\Http\Controllers\Seller\OrderController;
use App\Http\Controllers\Seller\ProductImageSellerController;
use App\Http\Controllers\Seller\ProductsSellerController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterStoreController;
use App\Http\Controllers\Seller\ProfileStoreController;
use App\Http\Controllers\Seller\StatisticsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//use App\Http\Controllers\Auth\FacebookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home');
});

// route user
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/category/{cate_slug}/{prod_slug}', [FrontendController::class, 'productView']);

Route::get('/stall/{seller_id}', [FrontendController::class, 'showStall'])->name('showStall');

//relate search
Route::get('/product-list', [FrontendController::class,'getProductList']);
Route::get('/search', [FrontendController::class,'search'])->name('search');
Route::post('/search', [FrontendController::class,'searchPost'])->name('searchPost');
Route::get('/clear', [FrontendController::class,'clearSearch'])->name('clear');
Route::post('/sort', [FrontendController::class,'sort'])->name('sort');
Route::get('/getByCategory/{id}', [FrontendController::class,'getByCategory'])->name('getByCategory');

// https://localhost/ecommerce/public/cart
//Route::resource('cart',CartController::class);
Route::post('cart', [CartController::class, 'store'])->name('cart.store');

Auth::routes(['verify' => true]);

// user nhưng chỉ client vào dc
Route::middleware(['auth', 'user-access:user', 'verified'])->group(function () {
    Route::get('register-seller', [RegisterStoreController::class, 'registerForm'])->name('sellerForm');
    Route::post('register-seller', [RegisterStoreController::class, 'addNewSeller'])->name('sellerFormAdd');
//    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // https://localhost/ecommerce/public/cart
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::put('cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    // https://localhost/ecommerce/public/checkout
    Route::get('checkout/{cart}', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('checkout/{cart}', [CheckoutController::class, 'store'])->name('checkout.store');

    // https://localhost/ecommerce/public/order-submitted
    Route::get('order-submitted', [FrontendController::class, 'order_submitted'])->name('submitted');

    // https://localhost/ecommerce/public/order-cancel
    Route::delete('order-cancel/{order_id}', [ConfirmController::class, 'cancelBill'])->name('cancel');

    // https://localhost/ecommerce/public/order-accepted
    Route::put('order-accepted/{order_id}', [ConfirmController::class, 'acceptPayment'])->name('accept');

    // https://localhost/ecommerce/public/profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profileClient');
    Route::post('profile', [ProfileController::class, 'update'])->name('profileClientEdit');

    // https://localhost/ecommerce/public/profile/change-password
    Route::get('profile/change-password', [ChangePasswordController::class, 'changePasswordClient'])->name('changePwdClient');
    Route::post('profile/change-password', [ChangePasswordController::class, 'updatePassword'])->name('changePwdClientEdit');

    // https://localhost/ecommerce/public/rating
    Route::resource('rating',RatingController::class);
});

// route seller
Route::group(['prefix' => 'seller'], function () {
    Route::middleware(['auth', 'user-access:seller', 'seller-access', 'verified'])->group(function () {
        Route::get('{name?}', [HomeController::class, 'sellerHome'])
            ->where('name', 'dashboard')
            ->name('sellerHome'); // default seller URL
//        Route::get('/home', [HomeController::class, 'sellerHome'])->name('seller.home');

        // https://localhost/ecommerce/public/seller/productSeller
        Route::resource('productSeller', ProductsSellerController::class);
        Route::get('product-image/{product_image_id}/delete', [ProductImageSellerController::class, 'destroyImage'])->name('productImageDelSeller');

        // https://localhost/ecommerce/public/seller/profile
        Route::get('profile', [ProfileController::class, 'index'])->name('profileSeller');
        Route::post('profile', [ProfileController::class, 'updateSeller'])->name('profileSellerEdit');

        Route::get('profile/store', [ProfileStoreController::class, 'index'])->name('profileStore');
        Route::post('profile/store', [ProfileStoreController::class, 'update'])->name('profileStoreEdit');

        Route::get('profile/change-password', [ChangePasswordController::class, 'changePasswordSeller'])->name('changePwdSeller');
        Route::post('profile/change-password', [ChangePasswordController::class, 'updatePassword'])->name('changePwdSellerEdit');

        // https://localhost/ecommerce/public/seller/productSeller
        Route::resource('order', OrderController::class);

        //statistic
        Route::post('/dashboard', [StatisticsController::class,'statistic'])->name('statistic');

        Route::get('/clear', [StatisticsController::class,'clearStatistic'])->name('clearStatistic');


    });
});

// route admin
Route::group(['prefix' => 'admin'], function () {
    Route::middleware(['auth', 'user-access:admin', 'verified'])->group(function () {
        Route::get('{name?}', [HomeController::class, 'adminHome'])
            ->where('name', 'dashboard')
            ->name('dashboard'); // default admin URL
//        Route::get('dashboard', [HomeController::class, 'adminHome'])->name('admin.home');

        // "admin::admin.area.index"
        // https://localhost/ecommerce/public/admin/category
        Route::resource('category', CategoriesController::class);

        // "admin::admin.area.index"
        // https://localhost/ecommerce/public/admin/brand
        Route::resource('brand', BrandsController::class);

        // "admin::admin.area.index"
        // https://localhost/ecommerce/public/admin/product
        Route::resource('product', ProductsController::class);
        Route::get('product-image/{product_image_id}/delete', [ProductImageController::class, 'destroyImage'])->name('productImageDel');

        // "admin::admin.area.index"
        // https://localhost/ecommerce/public/admin/attribute
        Route::group(['prefix' => 'attribute'], function () {
            Route::get('/', [AttributeController::class, 'index'])->name('attribute');
            Route::resource('color', ColorsController::class); // màu sắc
            Route::resource('dimension', DimensionController::class); // kích thước đồ đạc
            Route::resource('size', SizeController::class); // kích cỡ quần áo
            Route::resource('memory', MemoryController::class); // bộ nhớ
            Route::resource('volume', VolumeController::class); // thể tích, khối lượng, trọng lượng, dung lượng, diện tích
        });

        // "admin::admin.area.index"
        // https://localhost/ecommerce/public/admin/user
        Route::resource('user', UsersController::class);

        // "admin::admin.area.index"
        // https://localhost/ecommerce/public/admin/seller
        Route::resource('seller', SellersController::class);

        // "admin::admin.area.index"
        // https://localhost/ecommerce/public/admin/profile
        Route::get('profile', [ProfileController::class, 'index'])->name('profileAdmin');
        Route::post('profile', [ProfileController::class, 'update'])->name('profileAdminEdit');

        // "admin::admin.area.index"
        // https://localhost/ecommerce/public/admin/change-password
        Route::get('change-password', [ChangePasswordController::class, 'changePassword'])->name('changePwdAdmin');
        Route::post('change-password', [ChangePasswordController::class, 'updatePassword'])->name('changePwdAdminEdit');
    });

});

Route::controller(FacebookController::class)->group(function () {
    Route::get('auth/facebook', 'redirectToFacebook')->name('auth.facebook');
    Route::get('auth/facebook/callback', 'handleFacebookCallback');
});

Route::controller(GoogleController::class)->group(function () {
    Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});

Route::match(['get', 'post'], 'botman', [BotManController::class, 'handle']); // careful

Route::get('chatbot', [FrontendController::class, 'chatBot'])->name('chatbot');
