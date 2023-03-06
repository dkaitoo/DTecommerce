<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        // nhớ check validate
        $product_id = $request->input('product_id');
        $stars_rated = $request->input('rating');
        $user_review = $request->input('user_review');
        $product_check = Product::where('id', $product_id)->where('status', '1')->first();
        if ($product_check) {
            // ktra san pham da dc mua boi user nay hay chua
            $verified_purchase = Order::where('orders.user_id', Auth::id())
                ->join('order_items', 'orders.id', 'order_items.order_id')
                ->where('order_items.product_id', $product_id)
                ->where('order_items.process_status', '3') // phải mua hàng rồi
                ->get();
            if ($verified_purchase->count() > 0) {
                $existing_rating = Rating::where('user_id', Auth::id())->where('product_id', $product_id)->first();
                // nếu đã đánh giá r
                if($existing_rating){
                    Rating::where('user_id', Auth::id())
                        ->where('product_id', $product_id)->update([
                        'stars_rated'=> $stars_rated,
                        'user_review'=> $user_review,
                    ]);
                }
                else{
                    Rating::create([
                        'user_id' => Auth::id(),
                        'product_id' => $product_id,
                        'stars_rated' => $stars_rated,
                        'user_review' => $user_review,
                    ]);

                }
                // cập nhật lại cột trung bình
                $ratings = Rating::where('product_id', $product_id)->get();
                $rating_sum = Rating::where('product_id', $product_id)->sum('stars_rated');
                if($ratings->count() > 0){
                    $rating_value = $rating_sum/$ratings->count();
                    Product::where('id', $product_id)->update(['average_star'=>$rating_value]);
                }
                return redirect('/category/'.$product_check->category->slug.'/'.$product_id )->with('commit','Cảm ơn bạn đã đánh giá sản phẩm của cửa hàng chúng tôi.');
            }else{
                return redirect('/category/'.$product_check->category->slug.'/'.$product_id )->with('commit','Bạn không thể đánh giá nếu chưa mua sản phẩm này.');
            }
        }else{
            return redirect('/category/'.$product_check.'/'.$product_id )->with('commit','Mã sản phẩm không hợp lệ.');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function show(Rating $rating)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function edit(Rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rating $rating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rating $rating)
    {
        //
    }
}
