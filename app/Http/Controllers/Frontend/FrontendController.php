<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{
    //hien thi trang chi tiet san pham
    public function productView($cate_slug, $prod_id)
    {
        if(Category::where('slug',$cate_slug)->exists()){
            // tim sp vs id tuong ung
            if(Product::where('id', $prod_id)->exists()){
                $product = Product::where('id', $prod_id)->first();
                $ratings = Rating::where('product_id', $product->id)->get();
                $rating_sum = Rating::where('product_id', $product->id)->sum('stars_rated');
                $rating_value = 0;
                if($ratings->count() > 0){
                    $rating_value = $rating_sum/$ratings->count();

                }
                // rating 1-5
                $rating_sum_1star = Rating::where('product_id', $product->id)->where('stars_rated', '1')->count();
                $rating_sum_2star = Rating::where('product_id', $product->id)->where('stars_rated', '2')->count();
                $rating_sum_3star = Rating::where('product_id', $product->id)->where('stars_rated', '3')->count();
                $rating_sum_4star = Rating::where('product_id', $product->id)->where('stars_rated', '4')->count();
                $rating_sum_5star = Rating::where('product_id', $product->id)->where('stars_rated', '5')->count();


                $attributes_name = [];
                $attributes = json_decode($product->attributes ?? ''); // lấy thuộc tính của sản phẩm này

                if($attributes != ''){
                    foreach ($attributes as $attr){
                        $attributes_filter = Attribute::where(['id'=>$attr,'status' => '1'])->get();
                        if($attributes_filter){
                            $attributes_name[] = $attributes_filter[0]->name;
                        }
                    }
                }
                $user_rating = Rating::where('product_id', $product->id)
                    ->where('user_id', Auth::id())->first();

                // paginate comment + star
                $rating_paginate = Rating::where('product_id', $product->id)->orderBy('created_at', 'desc')->paginate(10);

                // relate product by the loai
                $related_product = Product::where('category_id',$product->category_id)
                            ->where('id', '<>', $product->id)
                            ->get();

                // relate product by seller
                $related_product_seller = Product::where('seller_id',$product->seller_id)
                            ->where('id', '<>', $product->id)
                            ->get();

                return view('frontend.detailProduct',compact('product','attributes_name',
                    'attributes','ratings','rating_value', 'user_rating', 'rating_sum_1star', 'rating_sum_2star',
                    'rating_sum_3star', 'rating_sum_4star','rating_sum_5star', 'related_product', 'related_product_seller',
                    'rating_paginate'
                ));
            }
            else{
                return redirect()->route('home')->with('error','Sản phẩm này không tồn tại');
            }
        }
        else{
            return redirect()->route('home')->with('error','Loại sản phẩm này không tồn tại');
        }
    }

    // hiển thị thông báo đặt hàng thành công
    public function order_submitted()
    {
        if($order_id = Session::get('order_id')){
            $order = Order::where('id', $order_id)->first();
            return view('frontend.orderSubmitted', compact('order'));
        }
        // kiểm tra xem thanh toán = pth j, nếu có tham số trả về thì là do vnpay kích hoạt
        if(isset($_GET['vnp_TxnRef'])){
            // lưu lại giá trị here???
            $order2 = Order::where('bill_id', $_GET['vnp_TxnRef']);
            $order2->update(['payed'=>'1']); // cập nhật lại là đã thanh toán r
            $order_payed = $order2->first();
            return view('frontend.orderSubmitted', compact('order_payed'));
        }
        return redirect()->route('home');
    }

    // hiển thi chat bot
    public function chatBot()
    {
        return view('frontend.chatbot');
    }

    // hiển thị gian hàng
    public function showStall(Request $request, $id)
    {
        $seller = Seller::where('id', $id)->first();
        $count_products = Product::where('seller_id', $id)->where('status', '1')->count();

        $products_lazy = Product::where('seller_id', $id) // where('trending','1')->
            ->where('status', '1')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(6); // khi chạy vòng for khi gọi 1 lần sẽ giảm 1 lenghth xuống

        if ($request->ajax()) {
            $html = '<div class="col-md-12"><div class="row">';
            foreach ($products_lazy as $product) {
                $html .= '<div class="col-md-2 col-sm-3 col-xs-6"><div class="product"><div class="product-img">';
                if($product->productImages->count() > 0)
                    $html .=  '<img src="'.url(($product->productImages[0]->image != null) ? $product->productImages[0]->image : '/img/giftbox.png').'" alt="">';
                else
                    $html .=  '<img src="'.url('/img/giftbox.png').'" alt="">';

//                $html .= '<div class="product-label"><span class="new">NEW</span></div></div><div class="product-body">';
                if ($product->created_at >= date('Y-m-d', strtotime(config('app.new_arrival'))) ){
                    $html .= '<div class="product-label"><span class="new">NEW</span></div>';
                }

                $html .= '</div><div class="product-body">';
                $html .= '<p class="product-category">'.$product->category->name.'</p>';
                $html .= '<h3 class="product-name"><a href="'.url('/category/'.$product->category->slug.'/'.$product->id).'">'.$product->name.'</a></h3>';
                $html .= '<div class="product-rating">';
                for($i = 1; $i <= number_format($product->average_star); $i++){
                    $html .= '<i class="fa fa-star"></i>';
                }
                for($j = $product->average_star + 1; $j <= 5; $j++){
                    $html .= '<i class="fa fa-star-o"></i>';
                }
                $html .=  '</div>';
                $html .= '<div class="product-btns">';
                $html .= '<h4 class="product-price">'.number_format($product->selling_price, 0, '', '.').'đ<br>';
                $html .= '<del class="product-old-price">'.number_format($product->original_price, 0, '', '.').'đ</del></h4></div></div>';
                $html .= '</div></div>';
            }

            $html .= '</div></div>';

            return response()->json(['data'=>$html, 'count_data'=> count($products_lazy)]);
        }

        return view('frontend.stall', compact('seller', 'count_products'));
    }

    //search
    public function search()
    {
        $products_search = Product::where('status','1');
        if(Session::has('search_key')){
            $search_key = Session::get('search_key');

            $products_search = $products_search->where("tittle", "LIKE", "%$search_key%") // search theo title
                ->orWhere("name", "LIKE", "%$search_key%");

        }
        if(Session::has('category_filter')){
            $category_filter = Session::get('category_filter');
//            dd($category_filter);
            $products_search = $products_search->whereIn("category_id", $category_filter);

        }
        if(Session::has('brand_filter')){
            $brand_filter = Session::get('brand_filter');

            $products_search = $products_search->whereIn("brand", $brand_filter);
        }

        // query min value
        if(Session::has('price_min')){
            $price_min = (int) Session::get('price_min');
            $products_search = $products_search->where("selling_price", '>=' ,$price_min);
        }

        // query max value
        if(Session::has('price_max')){
            $price_max = (int) Session::get('price_max');

            $products_search = $products_search->where("selling_price", '<=' ,$price_max);
        }

        // sort by selected sort
        if(Session::has('sort_filter')){
            $sort_filter = Session::get('sort_filter');
            if($sort_filter == 'low-to-high'){
                $products_search = $products_search->orderBy('selling_price', 'ASC');
            }elseif($sort_filter == 'high-to-low'){
                $products_search = $products_search->orderBy('selling_price', 'DESC');
            }else{
                $products_search = $products_search->orderBy('average_star', 'DESC');
            }
        }else{
            $products_search = $products_search->orderBy('average_star', 'DESC');
        }

        $products_search = $products_search->paginate(12); // cứ 12 sản phẩm là 1 trang

        return view('frontend.search', compact('products_search'));
    }

    public function searchPost(Request $request)
    {
        $this->clearSession();
        if($request->postSearch){
            Session::put('search_key',$request->product_name); // nếu có thì mới đặt lại giá trị mới
        }
        // 1 form
        // có thể xử lý những thứ khác như catogory ở đây
        Session::put('category_filter',$request->category_checked);
        Session::put('price_min',$request->price_min);
        Session::put('price_max',$request->price_max);
        Session::put('brand_filter',$request->brand_checked);

        return redirect()->route('search');
    }

    public function clearSearch()
    {
        // clear tat ca tim kiem
        $this->clearSession();

        return redirect()->route('search');
    }

    public function getProductList()
    {
        $products = Product::select('tittle')->where('status', '1')->get();
        $data = [];

        foreach ($products as $product){
            $data[] = $product['tittle'];
        }
        return response()->json($data);
    }

    //filter
    public function sort(Request $request)
    {
        // có thể xử lý những thứ khác như catogry ở đây
        $sortValue= $request->sort;

        Session::put('sort_filter',$sortValue);

        return redirect()->route('search');
    }

    // nav header
    public function getByCategory($id){
        // bỏ search để tránh sai khi filter
        $this->clearSession();

        // set session before go search
        Session::put('category_filter', [$id]); // neu an qua the loai khac, no se replace lai biến này
        return redirect()->route('search');
    }

    private function clearSession(){
        Session::forget('search_key');
        Session::forget('price_min');
        Session::forget('price_max');
        Session::forget('category_filter'); // neu an qua the loai khac, no se replace lai biến này
        Session::forget('brand_filter');
        Session::forget('sort_filter');
    }

}


