<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class StatisticsController extends Controller
{
    //
    public function statistic(Request $request)
    {
        // custom lỗi
//        dd($request->end_date);
        $messages = [
            'start_date.date_format' => '"Từ ngày" phải đúng định dạng dd/mm/YYYY',
            'end_date.date_format' => '"Đến ngày" phải đúng định dạng dd/mm/YYYY',
        ];
        $rules = [
            'start_date' => 'nullable|date_format:m/d/Y',
            'end_date' => 'nullable|date_format:m/d/Y'
        ];

        // check input
        $validator = Validator::make($request->all(),$rules,$messages);

        if ($validator->fails()){
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        if($request->start_date > $request->end_date){
            return redirect()->back()->with('error', '"Từ ngày" phải nhỏ hơn hoặc bằng "Đến ngày"');
        }
        Session::put('start_date',$request->start_date);
        Session::put('end_date',$request->end_date);

        return redirect()->route('sellerHome');
    }

    public function clearStatistic()
    {
        // clear tat ca tim kiem
        Session::forget('start_date');
        Session::forget('end_date');

        return redirect()->route('sellerHome');
    }
}
