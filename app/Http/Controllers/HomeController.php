<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $product_arrivals = Product::where('status','1')
            ->where('created_at', '>=', date('Y-m-d', strtotime(config('app.new_arrival')))) // 6 tuần đổ lại cua 10 sp
            ->orderBy('created_at', 'DESC')->take(10)->get(); // do lay 10 sp nen nó sẽ cắt ngang theo thứ tự tăng dần -> đảo ngược thành giảm dần
        $product_limit = Product::where('trending','1')->where('status','1')->orderBy('created_at', 'DESC')->take(10)->get(); //cua 10 sp

        if ($request->ajax() && Session::has('recommend')) {
            $random_value = Session::get('recommend');
            $products_recommend = Product::orderBy($random_value, 'DESC')->orderBy('id', 'ASC')->paginate(6); // khi chạy vòng for khi gọi 1 lần sẽ giảm 1 lenghth xuống
            $html = '<div class="col-md-12"><div class="row">';
            foreach ($products_recommend as $product) {
                $html .= '<div class="col-md-2 col-sm-3 col-xs-6"><div class="product"><div class="product-img">';
                if($product->productImages->count() > 0)
                    $html .=  '<img src="'.url(($product->productImages[0]->image != null) ? $product->productImages[0]->image : '/img/giftbox.png').'" alt="">';
                else
                    $html .=  '<img src="'.url('/img/giftbox.png').'" alt="">';

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
                for($j = number_format($product->average_star) + 1; $j <= 5; $j++){
                    $html .= '<i class="fa fa-star-o"></i>';
                }
                $html .=  '</div>';
                $html .= '<div class="product-btns">';
                $html .= '<h4 class="product-price">'.number_format($product->selling_price, 0, '', '.').'đ<br>';
                $html .= '<del class="product-old-price">'.number_format($product->original_price, 0, '', '.').'đ</del></h4></div></div>';
//                $html .= '<div class="add-to-cart"><button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> Add to cart</button></div></div></div>';
                $html .= '</div></div>';
            }

            $html .= '</div></div>';

            return response()->json(['data'=>$html, 'count_data'=> count($products_recommend)]);
        }

        // tạo 1 giá trị random khi refresh page để phục vụ việc ajax khi load more
        $list_random = ['trending','created_at','average_star','selling_price']; // 'category_id','brand'-> đây là many -> trùng product nếu dùng 2 cái này
        $key = array_rand($list_random);
        $value = $list_random[$key];
        Session::put('recommend',$value);
        // kiểm tra user có hay k
        if (Auth::check()){
            $user = Auth::user();
            // chặn truy cập trái phép
            if (!Auth::user()->hasVerifiedEmail()) {
//                Auth::logout();
//                event(new Registered($user)); // gọi lại hàm send
                return redirect()->route('verification.notice'); // chạy dc nếu tự dưng ng dùng lỡ quay lại trc
//                return redirect()->back();
            }

            $seller = Seller::where('user_id',$user->id)->first();
            return view('home',compact('user','seller', 'product_limit','product_arrivals'));
        }
        return view('home', compact('product_limit','product_arrivals'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sellerHome(Request $request)
    {
        $this->middleware(['auth','verified']);

        // statistic ??
        if ($request->ajax()) {

            $data = Product::join('order_items', 'order_items.product_id', '=', 'products.id')
                ->join('sellers','sellers.id', '=',  'products.seller_id')
                // 1 where de loc don hang nao da hoan tat
                ->where('sellers.id', Auth::user()->profileSeller->id) // tim dung id cua seller
                ->where('order_items.process_status', '3');

            // nếu có session
            if(Session::get('start_date') || Session::get('end_date')){
                if($start = Session::get('start_date')){
                    $data = $data->where('order_items.created_at', '>=',  date('Y-m-d H:i:s', strtotime($start))); // format lại cho tương ứng do jquery là dmy còn đây là ymd
                }
                if($end = Session::get('end_date')){
                    $data = $data->where('order_items.created_at', '<=', date('Y-m-d H:i:s', strtotime($end)));
                }
            }else{
                // hiển thị khoảng thời gian bán hàng trong 1 tuần

//                $data = $data->where('order_items.created_at', '>=', date('Y-m-d H:i:s', strtotime("-1 week")));
//                $data = $data->where('order_items.created_at', '<=', date("Y-m-d H:i:s"));
                $data = $data->whereBetween('order_items.created_at', [date('Y-m-d H:i:s', strtotime("-1 week")), date("Y-m-d H:i:s")]);
            }
//            dd(date("Y-m-d H:i:s"));
            $data = $data->selectRaw('DATE(order_items.created_at) as date, sum(order_items.qty*products.selling_price) as sum, count(*) as bill')
                ->groupBy('date')
                ->get('date', 'sum', 'bill'); // show date(y/m/d), sum_price, bill_count
            return Datatables::of($data)
                ->addIndexColumn() // đánh số tự động từ 1
                ->addColumn('date', function($row){
                    return  date('d-m-Y', strtotime($row->date));
                })
                ->addColumn('sum', function($row){
                    return '(<b style="color:green">+</b>) ' . '<b class="text-success">'.number_format($row->sum, 0, '', '.'). 'đ'.'</b>';
                })
                ->addColumn('bill', function($row){
                    return $row->bill;
                })
                ->rawColumns(['date','sum','bill'])
                ->make();
        }

        return view('seller.sellerHome');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        $this->middleware(['auth','verified']);
        return view('admin.adminHome');
    }
}
