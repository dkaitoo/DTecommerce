<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class VolumeController extends Controller
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

            $data = Attribute::where('name','volume')->latest()->get();

            return Datatables::of($data)
                ->addIndexColumn() // đánh số tự động từ 1
                ->addColumn('value', function($row){
                    return $row->value;
                })
                ->addColumn('status', function($row){
                    return ($row->status) ? 'Đang mở' : 'Đã tắt';
                })
                ->addColumn('action', function($row){

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editAttribute">Sửa</a>'; //dùng id này để sửa

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteAttribute">Xóa</a>'; //dùng id này để xóa

                    return $btn;
                })
                ->rawColumns(['value','status','action'])
                ->make();
        }

        return view('admin.attributes.volumeProduct');
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
        //
        $messages = [
            'value.required' => 'Trường nhập không được để trống',
        ];
        $rules = [
            'value' => 'required', // giá trị
        ];

        // check input
        $validator = Validator::make($request->all(),$rules,$messages);

        if ($validator->fails()){
            return response()->json([
                'status'=>400,
                'error'=>$validator->errors()->first()
            ]);
        }
        $value =  $request->input('value');
        if (str_contains($value,'^2')){
            $value = str_replace('^2', ' &#178;', $value);
        }
        else if(str_contains($value,'^3')){
            $value = str_replace('^3', ' &#179;', $value);
        }

        $details = ['name' => 'volume',
            'value' => $value,
            'status' => $request->input('status') ? '1' : '0',
        ];

        // Thêm/sửa
        Attribute::updateOrCreate([
            'id' => $request->input('attribute_id')// lấy id từ form
        ], $details);

        return response()->json([
            'status'=>200,
            'message'=>'Lưu dữ liệu thành công.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function show(Attribute $attribute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        // tìm id để trả ra phía client nhằm lấy dữ liệu để hiển thị cho việc edit
        $memory = Attribute::find($id);
        return response()->json($memory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attribute $attribute)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
        Attribute::where('id',$id)->delete();
        return response()->json(['success'=>'Đã xóa dữ liệu này thành công.']);
    }
}
