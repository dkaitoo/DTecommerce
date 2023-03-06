<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mews\Purifier\Facades\Purifier;
use Yajra\DataTables\Facades\DataTables;

class ProductsController extends Controller
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

            $data = Product::latest()->get();

            return Datatables::of($data)
                ->addIndexColumn() // đánh số tự động từ 1
                ->addColumn('selling_price', function($row){
                    return number_format($row->selling_price, 0, '', '.').'đ';
                })
                ->addColumn('category_id', function($row){
                    return $row->category->name;
                })
                ->addColumn('seller_id', function($row){
                    return $row->seller->name;
                })
                ->addColumn('action', function($row){
                    $btn =  '<a href="'.route('product.index').'/' . $row->id.'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="View" class="view btn btn-success btn-sm viewProduct" style="margin-right: 5px;"><i class="fa fa-eye" aria-hidden="true"></i> Xem</a>'; //dùng id này để sửa

                    $btn = $btn. '<a href="'.route('product.index').'/' . $row->id.'/edit" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-info btn-sm editProduct" style="margin-right: 5px;"><i class="fa fa-gavel" aria-hidden="true"></i> Sửa</a>'; //dùng id này để sửa

                    return $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct" style="margin-right: 0px;"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>'; //dùng id này để xóa

                })
                ->rawColumns(['selling_price','category_id','seller_id','action'])
                ->make();
        }
        return view('admin.products.index');

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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Product $product)
    {
        //
        $attributes = json_decode($product->attributes ?? '');

        $attributes_name = [];

        if($attributes != ''){
            foreach ($attributes as $attr){
                $attributes_filter = Attribute::where(['id'=>$attr,'status' => '1'])->get();
                if($attributes_filter){
                    $attributes_name[] = $attributes_filter[0]->name;
                }
//            dd($attributes_filter[0]->name);
            }
        }

        return view('admin.products.showProduct',compact('product', 'attributes','attributes_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $product_id)
    {
        // get data from db
        $product = Product::findOrFail($product_id);
        return view('admin.products.editProduct',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, int $product_id)
    {
        // custom lỗi
        $messages = [
            'name.required' => 'Tên sản phẩm không được để trống',
            'original_price.required' => 'Giá gốc không được để trống',
            'selling_price.required' => 'Giá sau khi giảm không được để trống',
            'selling_price.lt' => 'Giá sau khi giảm phải nhỏ hơn giá gốc',
            'qty.required' => 'Số lượng không được để trống',

        ];
        $rules = [
            'name' => 'required',
            'original_price' => 'required',
            'selling_price' => 'required|lt:original_price', // less than (<)
            'qty' => 'required',
        ];

        // check input
        $validator = Validator::make($request->all(),$rules,$messages);

        if ($validator->fails()){
            return redirect()->back()->with('error', $validator->errors()->first());

        }

        // cần lưu các name của các radio về 1 array để đưa vào csdl !!!
        $attributes_checkbox = $request->attribute;
        $attributes_radio = [];
        $name_product = $request->input('name');

        if($request->dimension){
            $dimension = $request->dimension;
            $attributes_radio[] = $dimension;
            $name_product .= ' '. Attribute::where(['status' => '1'])->where('id',$dimension)->first()->value;
        }
        if($request->memory){
            $memory = $request->memory;
            $attributes_radio[] = $memory;
            $name_product .= ' '. Attribute::where(['status' => '1'])->where('id',$memory)->first()->value;
        }
        if($request->volume){
            $volume = $request->volume;
            $attributes_radio[] = $volume;
            $name_product .= ' ' . Attribute::where(['status' => '1'])->where('id',$volume)->first()->value;
        }

        if($request->other_attribute)
        {
            $name_product .= ' '.$request->other_attribute;
        }

        $attributes_arr = [];
        if ($attributes_checkbox && $attributes_radio)
            $attributes_arr = array_merge($attributes_checkbox, $attributes_radio);
        elseif ($attributes_checkbox)
            $attributes_arr = $attributes_checkbox;
        elseif ($attributes_radio)
            $attributes_arr = $attributes_radio;


        $product = Product::where('id',$product_id);
        if($product){
            $product->update([
                'category_id'=> $request->input('category_id'), // phải giống vs select?
                'name'=>$request->input('name'),
                'tittle' => Purifier::clean($name_product), // hiển thị dưới dạng html
                'brand' => $request->input('brand'),
                'qty'=> $request->input('qty'),
                'attributes' => json_encode($attributes_arr), // dua ve json
                'description' => Purifier::clean($request->input('description'),'youtube'), // chống xss
                'original_price'=> $request->input('original_price'),
                'selling_price'=> $request->input('selling_price'),
                'status' => $request->input('status') ? '1' : '0',
                'trending' => $request->input('trending') ? '1' : '0',
                'other_attribute' => $request->input('other_attribute'),
            ]);
            if($request->hasFile('image')){

                $uploadPath = 'assets/uploads/product/';
                $i = 1;
                foreach ($request->file('image') as $imageFile){
                    $extension = $imageFile->getClientOriginalExtension();

                    $fileName = date('YmdHis').$i++ . "." . $extension;

                    $imageFile->move($uploadPath, $fileName);
                    $finalImagePathName = $uploadPath.$fileName;

                    // them vao db
                    $product_image = $product->first();
                    $product_image->productImages()->create([
                        'product_id' =>$product_image->id,
                        'image' => $finalImagePathName
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Cập nhật sản phẩm thành công!');

        }else{
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩm với Id này');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $product_id)
    {
        //
        $product = Product::findOrFail($product_id);
        if($product->productImages()){
            foreach ($product->productImages() as $image){
                if(File::exists($image->image)){
                    File::delete($image->image); // xóa file trên hệ thống

                }
            }
        }
        $product->delete();
        return response()->json(['success'=>'Đã xóa sản phẩm này thành công.']);
    }

}
