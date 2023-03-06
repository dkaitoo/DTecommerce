<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfirmController extends Controller
{
    //
    public function waitConfirm(){

    }

    //
    public function confirmed(){

    }

    // hủy nguyên 1 bill
    public function cancelBill($id){
        $order = Order::findOrFail($id);
        //Xử lý cộng lại số lượng sản phẩm cho đơn hàng đã bị hủy
            // cần xử lý 1 vòng lặp for để lấy id r check vs id dưới
            DB::transaction(function () use ( $order) {
//                $product_order = $order->order_items->pluck('product_id','qty')->toArray();
                $product_order = $order->order_items()->select('product_id','qty')->get();
//                dd($product_order);
                foreach ($product_order as $product){
                    $product_updated = Product::findOrFail($product->product_id); // goi ra colection
                    Product::where('id',$product->product_id)->update(['qty' => $product->qty + $product_updated->qty]); // builder
                }
                $order->delete();
            });
        return response()->json(['status'=>3,'message'=>'Đã hủy đơn hàng này.', 'id' =>$id]);
    }

    // khi đơn hàng đã giao tới-> client accept->history
    public function acceptPayment($id)
    {
        DB::transaction(function () use ($id) {
            OrderItem::findOrfail($id)->update(['process_status'=>'3']); // đã giao
            // cập nhật lại số lượng đã bán
            $orderItem = OrderItem::where('id',$id)->first();
//            foreach($orderItem as $item){
//                $product = Product::where('id', $item->product_id)->first();
//                Product::where('id', $orderItem->product_id)->update(['sold'=>$product->sold + 1]);
//            }
            $product = Product::where('id', $orderItem->product_id)->first();
            Product::where('id', $orderItem->product_id)->update(['sold'=>$product->sold + 1]);
        });
        return redirect()->route('home')->with('success', 'Đơn hàng đã được giao thành công. Cám ơn bạn đã chọn mua hàng ở DT Ecommerce.');
    }
}
