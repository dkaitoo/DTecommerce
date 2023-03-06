<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;


class CategoriesController extends Controller
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

            $data = Category::latest()->get();

            return Datatables::of($data)
                ->addIndexColumn() // đánh số tự động từ 1
                ->addColumn('description', function($row){
                    $hide_script = strlen(strip_tags($row->description)) > 30 ? '...' : '';
                    return substr(strip_tags($row->description),0, 30) . $hide_script;
                })
                ->addColumn('image', 'image') //image.blade.php
                ->addColumn('action', function($row){

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editCategory" style="margin-right: 5px;"><i class="fa fa-gavel" aria-hidden="true"></i> Sửa</a>'; //dùng id này để sửa

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteCategory" style="margin-right: 5px;"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>'; //dùng id này để xóa

                    return $btn;
                })
                ->rawColumns(['image','action'])
                ->make();
        }

        return view('admin.typeProduct');
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
        // custom lỗi
        $messages = [
            'name.required' => 'Tên danh mục không được để trống',
            'slug.required' => 'Tên miền không được để trống',
            'slug.unique' => 'Tên miền đã tồn tại',
        ];
        $rules = [
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'.$request->input('category_id'), // tên miền
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
                    'description' => $request->input('description'),
                    'status' => $request->input('status') ? '1' : '0',
                    'popular' => $request->input('popular') ? '1' : '0',
//                    'meta_title' => $request->input('meta_title'),
            ];

        // kiểm tra có ảnh?
        if ($files = $request->file('image')) {

            //delete old file
            $destinationFile= 'assets/uploads/category'.$request->hidden_image;
            if(File::exists($destinationFile)){
                File::delete($destinationFile);
            }


            //insert new file
            $destinationPath = 'assets/uploads/category'; // upload path

            $fileName = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $fileName);
            $details['image'] = $fileName;
        }
        // Thêm/sửa thể loại
        Category::updateOrCreate([
            'id' => $request->input('category_id')// lấy id từ form
        ], $details);

        return response()->json([
            'status'=>200,
            'message'=>'Lưu danh mục thành công.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // tìm id để trả ra phía client nhằm lấy dữ liệu để hiển thị cho việc edit
        $category = Category::find($id);
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
        $data = Category::where('id',$id)->first(['image']);
//        Category::find($id)->delete()->first(['image']);
        File::delete('assets/uploads/category/'.$data->image);
        Category::where('id',$id)->delete();
        return response()->json(['success'=>'Đã xóa danh mục này thành công.']);
    }
}
