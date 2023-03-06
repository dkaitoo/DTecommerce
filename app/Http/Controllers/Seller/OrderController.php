<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $user = Auth::user();
            $data = Product::join('order_items', 'order_items.product_id', '=', 'products.id')
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->join('sellers','sellers.id', '=',  'products.seller_id')
                ->where('sellers.id', Auth::user()->profileSeller->id) // tim dung id cua seller
                ->orderBy('order_items.created_at','desc')
                ->groupBy('order_id') // nên sẽ ẩn đi 1 cột?
                ->get(['*','orders.name']);

            return Datatables::of($data)
                ->addColumn('DT_RowIndex', function($row){
                    return '<span style="color: #40739e">'.'#'.$row->bill_id.'</span>';
                })
                ->addColumn('name_product', function($row){
                    // tim cac san pham thuoc order id (da dc loc o tren)
                    $order_products = OrderItem::where('order_id', $row->order_id)->get();
                    $title = '<ul>';
                    foreach ($order_products as $order_product){
                        if($order_product->products->seller_id == Auth::user()->profileSeller->id){
                            $title .= '<li>'.$order_product->products->tittle. ' <b>x</b> ' . $order_product->qty . '&nbsp;&nbsp;&nbsp;';
                            if($order_product->process_status < 3)
                                $title .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$order_product->id.
                                    '" data-original-title="Delete" class="btn btn-danger btn-sm deleteCategory" style="border-radius: 15px; margin-bottom: 5px;"><i class="fa fa-trash" aria-hidden="true"></i> Hủy</a>';
                            $title .= '</li>';
                        }
                    }

                    $title .= '</ul>';

                    return $title;
                })
                ->addColumn('selling_price', function($row){
                    $order_products = OrderItem::where('order_id', $row->order_id)->get();
                    $sum = 0;
                    foreach ($order_products as $order_product){
                        if($order_product->products->seller_id == Auth::user()->profileSeller->id){
                            $sum += $order_product->products->selling_price * $order_product->qty ;
                        }
                    }
                    return  '<b class="text-danger">'.number_format($sum, 0, '', '.'). 'đ'.'</b>';

                })
                ->addColumn('name_client', function($row){
                    return $row->name;
                })
                ->addColumn('status', function($row){
                    $order_products = OrderItem::where('order_id', $row->order_id)->get();
                    $title = '<ul>';
                    foreach ($order_products as $order_product){
                        if($order_product->products->seller_id == Auth::user()->profileSeller->id){
                            $status = '';
                            switch ($row->process_status){
                                case(0): {
                                    $status =  'Chờ xác nhận';
                                    break;
                                }
                                case(1): {
                                    $status =  'Đã xác nhận';
                                    break;
                                }
                                case(2): {
                                    $status =  'Đang vận chuyển';
                                    break;
                                }
                                case(3): {
                                    $status =  'Đã giao';
                                    break;
                                }
                            }
                            $title .= '<li style="margin-bottom: 9px;"> <span class="text-white" style="margin-right: 8px; border-radius: 15px; padding: 5px; background-color: #8854d0; font-size: 13px;">'.$status.'</span></li>';
                        }
                    }

                    $title .= '</ul>';

                    return $title;
                })
                ->addColumn('action', function($row){
//                    if (!$row->profileSeller->approved)
//                        return  '<a href="'.route('seller.index').'/' . $row->profileSeller->id.'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="View" class="view btn btn-danger btn-sm viewProduct">Xem để duyệt</a>'; //dùng id này để sửa

                    $btn = '<a href="'.route('order.show',$row->bill_id).'" data-toggle="tooltip"  data-id="'.$row->bill_id.'" data-original-title="View" class="view btn btn-success btn-sm viewProduct" style="margin-right: 8px; border-radius: 15px;"><i class="fa fa-eye" aria-hidden="true"></i><b> Xem</b></a>'; //dùng id này để sửa

                    return  $btn;

                })
                ->rawColumns(['DT_RowIndex','name_product','selling_price','name_client','status','action'])
                ->make();
        }
        return view('seller.orders.orderManagement');
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        //
        $order = Order::where(['bill_id'=>$id])->first();
        $seller_id = Auth::user()->profileSeller->id;

        return view('seller.orders.orderDetail',  compact('order','seller_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        //
        $order_item = OrderItem::where('id',$id)->update(['process_status'=>$request->input('status')]);
        if($order_item)
            return redirect()->back()->with('success','Trạng thái đơn hàng đã được thay đổi');
        return redirect()->back()->with('error','Không thể thay đổi trạng thái đơn hàng');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    // không nên phục hồi lại số lượng sản phẩm khi xóa (ảnh hưởng tới client vì client nghĩ sẽ còn hàng mặc dù seller hủy là do hết hàng)
    // vì đây là bên seller không phải client, nếu số lượng k đúng như mong mún thì seller có thể cập nhật lại số lượng sản phẩm.
    public function destroy($id)
    {
        // Chỉ xóa hóa đơn con
        $order_item = OrderItem::findOrFail($id);

        DB::transaction(function () use ($order_item) {
            // trừ tổng giá tiền và check nếu tiền đó có đảm bảo trên 100k
            $order = Order::findOrFail($order_item->order->id);

            $re_sum = $order->price - ($order_item->products->selling_price * $order_item->qty);
            if ($re_sum < 100000){
                // thêm 20k vào hóa đơn
                $order->update(['price'=>$re_sum + 20000]);
            }else{
                // cập nhật giá thôi
                $order->update(['price'=>$re_sum]);
            }
            $order_item->delete();

            // xóa lun cái hóa đơn cha nếu k còn hóa đơn con
            if($order->order_items->count() < 1){
                Order::findOrFail($order_item->order_id)->delete();
                return response()->json(['message'=>'Đã xóa đơn hàng này.']);
            }
        });
        return response()->json(['message'=>'Đã xóa sản phẩm trong đơn hàng này.']);
    }
}
