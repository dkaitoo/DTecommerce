<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BrandsController extends Controller
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

            $data = Brand::latest()->get();

            return Datatables::of($data)
                ->addIndexColumn() // đánh số tự động từ 1
                ->addColumn('status', function($row){
                    return ($row->status) ? 'Đang mở' : 'Đã tắt';
                })
                ->addColumn('action', function($row){

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editBrand"  style="margin-right: 5px;"><i class="fa fa-gavel" aria-hidden="true"></i> Sửa</a>'; //dùng id này để sửa

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBrand" style="margin-right: 5px;"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>'; //dùng id này để xóa

                    return $btn;
                })
                ->rawColumns(['status','action'])
                ->make();
        }

        return view('admin.brandProduct');
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
        // custom lỗi
        $messages = [
            'name.required' => 'Tên thương hiệu không được để trống',
            'slug.required' => 'Tên miền không được để trống',
        ];
        $rules = [
            'name' => 'required',
            'slug' => 'required', // tên miền
        ];

        // check input
        $validator = Validator::make($request->all(),$rules,$messages);

        if ($validator->fails()){
            return response()->json([
                'status'=>400,
                'error'=>$validator->errors()->first()
            ]);
        }

        $details = ['name' => $request->input('name'),
            'slug' => Str::slug($request->input('slug')),
            'status' => $request->input('status') ? '1' : '0',
        ];

        // Thêm/sửa thể loại
        Brand::updateOrCreate([
            'id' => $request->input('brand_id')// lấy id từ form
        ], $details);

        return response()->json([
            'status'=>200,
            'message'=>'Lưu thương hiệu thành công.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        // tìm id để trả ra phía client nhằm lấy dữ liệu để hiển thị cho việc edit
        $brand = Brand::find($id);
        return response()->json($brand);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Brand::where('id',$id)->delete();
        return response()->json(['success'=>'Đã xóa thương hiệu này thành công.']);
    }
}
