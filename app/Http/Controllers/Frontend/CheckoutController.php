<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    //
    public function index($prod_checked)
    {
//        $cart_products = Cart::where('')
        $prod_checked_dec = json_decode(urldecode($prod_checked)); // giải mã tham số r parse về array
        $chosen_carts =  Cart::whereIn('id',$prod_checked_dec)->get(); // wherein dùng cho mảng

//        dd($chosen_carts);
        if($chosen_carts)
            return view('frontend.checkOut', compact('chosen_carts','prod_checked'));
        return redirect()->route('home')->with('error', 'Bạn không có quyền vào trang đó');
    }

    public function store(Request $request, $prod_checked)
    {

        // custom lỗi
        $messages = [
            'name.required' => 'Họ tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'phone.required'=> 'Số điện thoại không được để trống',
            'phone.numeric'=> 'Số điện thoại phải là chữ số',
            'phone.digits'=> 'Số điện thoại phải đủ 10 chữ số',
            'address.required'=> 'Địa chỉ không được để trống',
            'city.required'=> 'Tỉnh/Thành phố không được để trống',
            'district.required'=> 'Quận/Huyện không được để trống',
            'payment.required' => 'Vui lòng chọn Phương thức thanh toán',
        ];
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:10',
            'address' => 'required',
            'city' => 'required',
            'district' => 'required',
            'payment' => 'required',
        ];

        // check input
        $validator = Validator::make($request->all(),$rules,$messages);

        if ($validator->fails()){
            return redirect()->back()->withInput()->with('error',
               $validator->errors()->first()
            ); // withInput() để lấy lại các trường đã nhập trc đó kết hợp vs old('name') bên kia
        }

        // thuc hien luu thong tin len don dat hang
        $product_checked = json_decode(urldecode($prod_checked));
        $unique_id = date('Ymd') . mt_rand() . Auth::user()->id;

        // kiểm tra số lượng hàng 1 lần nữa vì có thể 2+ đang mua cùng lúc
        foreach ($product_checked as $cart_id){
            $cart = Cart::where('id',$cart_id)->first();
            // sl sản phẩm trong giỏ hàng của 1 sp lớn hơn sl sản phẩm trong kho
            if($cart->qty > $cart->products->qty)
            {
                // cập nhật lại số lượng <= số lượng trong kho
                $cart->update(['qty' => $cart->products->qty]); // set lại số lượng = số lượng còn lại trong kho,
                // còn nếu cùng 1 sản phẩm nhưng khác thuộc tính thì seller sẽ kiểm tra vào xác nhận lại hàng
                return redirect()->route('cart.index')->with('message', 'Số lượng '.$cart->products->name.' trong kho không đủ để thực hiện');
            }
        }

        $details = [
            //  'carts' => json_encode($product_checked),
            'bill_id' => $unique_id,
            'user_id' => Auth::user()->id,
            'name'=> $request->input(['name']),
            'email'=> $request->input(['email']),
            'phone'=> $request->input(['phone']),
            'address'=> $request->input(['address']),
            'city'=> $request->input(['city']),
            'ward'=> $request->input(['district']),
            'message'=> $request->input(['message']),
            'price'=> $request->input(['price']),
            'payed' => '0',
//            'status'=> '0', // đang xử lý
        ];
        // vs COD
        if($request->input(['payment']) == 1){

            $order = $this->handle_order($details,$product_checked);

            return redirect()->route('submitted')->with('order_id', $order->id);

        }else if($request->input(['payment']) == 2){
            $validator = Validator::make($request->all(),['bank_code'=>'required'],['bank_code.required' =>'Vui lòng chọn ngân hàng để thanh toán']);
            if ($validator->fails()){
                return redirect()->back()->withInput()->with('error',
                    $validator->errors()->first()
                ); // withInput() để lấy lại các trường đã nhập trc đó kết hợp vs old('name') bên kia
            }

            $this->handle_order($details,$product_checked);

            $this->vnpay_payment($unique_id);
        }

        return redirect()->route('home')->with('error', 'Đã có lỗi xảy ra, không thể thanh toán được');
    }

    private function handle_order($details, $product_checked){
        $order = Order::create($details);

        foreach ($product_checked as $cart_id){
            $cart = Cart::where('id',$cart_id)->first();
            // tạo các vật phẩm cần thanh toán
            $order->order_items()->create([
                'product_id'=>$cart->product_id,
                'qty' => $cart->qty,
                'chosen_attribute' => $cart->chosen_attribute,
            ]);
            $qty_product = $cart->products->qty;
            // giảm số lượng sản phẩm xuống
            $cart->products()->update(['qty' => $qty_product  - $cart->qty]);
        }

        // xóa giỏ hang lun
        $cart_del = Cart::whereIn('id',$product_checked);
        $cart_del->delete();

        return $order;
    }

    private function vnpay_payment($unique_id){
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('submitted');
        $vnp_TmnCode = "2W2TWTKF";//Mã website tại VNPAY
        $vnp_HashSecret = "AAJZRDBXWRYOBUANQKBTQRKSXWQGPPSP"; //Chuỗi bí mật

        $vnp_TxnRef = $unique_id; //$_POST['order_id'] Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán đơn hàng';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $_POST['price'] * 100; // x100 vi cho việc .00
        $vnp_Locale = 'vn';
        $vnp_BankCode = $_POST['bank_code'];
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
//        $vnp_ExpireDate = $_POST['txtexpire'];
        //Billing
//        $vnp_Bill_Mobile = $_POST['txt_billing_mobile'];
//        $vnp_Bill_Email = $_POST['txt_billing_email'];
//        $fullName = trim($_POST['txt_billing_fullname']);
//        if (isset($fullName) && trim($fullName) != '') {
//            $name = explode(' ', $fullName);
//            $vnp_Bill_FirstName = array_shift($name);
//            $vnp_Bill_LastName = array_pop($name);
//        }
//        $vnp_Bill_Address=$_POST['txt_inv_addr1'];
//        $vnp_Bill_City=$_POST['txt_bill_city'];
//        $vnp_Bill_Country=$_POST['txt_bill_country'];
//        $vnp_Bill_State=$_POST['txt_bill_state'];
//        // Invoice
//        $vnp_Inv_Phone=$_POST['txt_inv_mobile'];
//        $vnp_Inv_Email=$_POST['txt_inv_email'];
//        $vnp_Inv_Customer=$_POST['txt_inv_customer'];
//        $vnp_Inv_Address=$_POST['txt_inv_addr1'];
//        $vnp_Inv_Company=$_POST['txt_inv_company'];
//        $vnp_Inv_Taxcode=$_POST['txt_inv_taxcode'];
//        $vnp_Inv_Type=$_POST['cbo_inv_type'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
//            "vnp_ExpireDate"=>$vnp_ExpireDate,
//            "vnp_Bill_Mobile"=>$vnp_Bill_Mobile,
//            "vnp_Bill_Email"=>$vnp_Bill_Email,
//            "vnp_Bill_FirstName"=>$vnp_Bill_FirstName,
//            "vnp_Bill_LastName"=>$vnp_Bill_LastName,
//            "vnp_Bill_Address"=>$vnp_Bill_Address,
//            "vnp_Bill_City"=>$vnp_Bill_City,
//            "vnp_Bill_Country"=>$vnp_Bill_Country,
//            "vnp_Inv_Phone"=>$vnp_Inv_Phone,
//            "vnp_Inv_Email"=>$vnp_Inv_Email,
//            "vnp_Inv_Customer"=>$vnp_Inv_Customer,
//            "vnp_Inv_Address"=>$vnp_Inv_Address,
//            "vnp_Inv_Company"=>$vnp_Inv_Company,
//            "vnp_Inv_Taxcode"=>$vnp_Inv_Taxcode,
//            "vnp_Inv_Type"=>$vnp_Inv_Type
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
        , 'message' => 'success'
        , 'data' => $vnp_Url);

        // khi click submit form
        if (isset($_POST['redirect'])) {

            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
    }

}
