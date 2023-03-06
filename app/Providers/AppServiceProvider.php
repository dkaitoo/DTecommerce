<?php

namespace App\Providers;

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Using view composer to set following variables globally
        view()->composer('*',function($view) {
//            $view->with('user', Auth::user());
            $view->with('clients', User::where('role', 0)->count());
            // admin -> notifications -> tài khoản bán hàng cần duyệt
            $view->with('seller_isApproved', Seller::where('approved','0')->count());

            //liên quan tới sản phẩm
            $view->with('products', Product::all());
            $view->with('categories', Category::where('status','1')->get());
            $view->with('brands', Brand::where(['status' => '1'])->get());

            $view->with('attributes_all', Attribute::where(['status' => '1'])->get());
            $view->with('colors', Attribute::where(['name'=> 'color','status' => '1'])->get());
            $view->with('sizes', Attribute::where(['name'=> 'size','status' => '1'])->get());
            $view->with('dimensions', Attribute::where(['name'=> 'dimension','status' => '1'])->get());
            $view->with('volumes', Attribute::where(['name'=> 'volume','status' => '1'])->get());
            $view->with('memories', Attribute::where(['name'=> 'memory','status' => '1'])->get());

        });
    }
}
