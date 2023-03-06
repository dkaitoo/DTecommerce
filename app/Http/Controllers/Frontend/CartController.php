<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $carts = Cart::where(['user_id'=>Auth::user()->id])->get();

        $orders_wait = Order::where(['user_id'=>Auth::user()->id])->orderBy('created_at','desc')->get(); // tien trinh don hang

        $orders_process = OrderItem::where('process_status','<','3')->orderBy('created_at','desc')->get(); // tien trinh don hang
        $count_process = $this->count($orders_process, 'process');

        $orders_history = OrderItem::where('process_status','3')->orderBy('updated_at','desc')->get(); // tien trinh don hang
        $count = $this->count($orders_history,'history');

        return view('frontend.cart', compact('carts','orders_wait', 'count','count_process'));
    }

    private function count($orders, $condition){
        $count = 0;
        $order_id = '';
        foreach($orders as $order_item){
            $order = $order_item->order()->where('user_id',Auth::user()->id)->first(); // user sở hữu hóa đơn con này
            if($order and $condition == 'history')
                $count++;
            elseif ($order and $condition == 'process'){
                if($order_id != $order->id){
                    $count++; // nếu id lần đầu vs lần 2 k = thì + 1 và tiến trình đơn hàng
                }
                $order_id = $order->id; // nếu id lần đầu vs lần 2 = nhau thì ráng tiếp
            }
        }
        return $count;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $product_id = $request->input('product_id');
        $product_qty = $request->input('product_qty');
        $chosen_attribute = $request->input('chosen_attribute');
//        dd($chosen_attribute);
        if(Auth::check()){
            //kiem tra sp co ton tai
            $prod_check = Product::where('id', $product_id)->first();

            if($prod_check){
                // check giỏ hàng có sản phẩm đó hay chưa, nếu có mà khác thuộc tính thì k cộng dồn ??
                $carts =  Cart::where(['product_id'=> $product_id, 'user_id' =>Auth::user()->id]);
                if($carts->get()){
                    foreach ($carts->get() as $cart){
                        // so sanh 2 array co su khac biet hay khong, dung ham array_diff
                        // tat ca thuoc tinh trong gio hang, phai co o trong san pham, neu sp bo thuoc tinh do thi gio hang van tinh san pham do ton tai thi la khac roi
                        $different_attr = array_diff(json_decode($cart->chosen_attribute), $chosen_attribute);
                        if(count($different_attr) === 0 and $prod_check->qty > 0){
                            // Không có sự khác biệt với giỏ hàng và sản phẩm phải còn hàng
                            $cart->update(['qty'=>($cart->qty + $product_qty)]);
                            return response()->json(['code' => 2,'status'=> $prod_check->name. " được thêm vào giỏ hàng lần nữa"]);
                        }
                    }

                }

                // nếu ra khỏi dc vòng for
                // chắc chắn có sự khác biệt thuộc tính
                if($prod_check->qty > 0){
                    Cart::create([
                        'user_id' => auth()->user()->id,
                        'product_id' => $product_id,
                        'qty' => $product_qty,
                        'chosen_attribute' => json_encode($chosen_attribute),
                    ]);
                    $count_cart = Cart::where('user_id', Auth::user()->id)->count();
                    return response()->json(['code' => 3, 'status'=> $prod_check->name. " đã thêm vào giỏ hàng", 'count'=>$count_cart]);
                }

                return response()->json(['code' => 0, 'status'=> $prod_check->name. " đã hết hàng"]);

            }
        }
        else{
            return response()->json(['status'=>'Đăng nhập để tiếp tục']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        //
        $product_qty = $request->input('product_qty');
        $cart =  Cart::where('id', $id)->first();
        if($cart){
            if($product_qty <= $cart->products->qty){
                Cart::where('id', $id)->update(['qty' => $product_qty]); // override lun
                return response()->json(['code' => 1, 'status'=> "Giỏ hàng đã cập nhật", 'qty' => $product_qty]);
            }
            return response()->json(['code' => 2, 'status'=> $cart->products->tittle. " chỉ còn ". $cart->products->qty . " sản phẩm"]);
        }

        return response()->json(['code' => 3, 'status'=>'Vui lòng thử lại sau!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
        $cart = Cart::where('id',$id)->first();
        Cart::where('id',$id)->delete();

        // $count_cart = Cart::where('user_id', Auth::user()->id)->count();
        return response()->json(['code' => 3,'status'=>'Đã xóa '. $cart->products->name .' khỏi giỏ hàng']);

    }
}
