<?php

namespace App\Http\Controllers\Admin;
use App\Models\ProductImage;
use Illuminate\Support\Facades\File;

class ProductImageController
{
    public function destroyImage(int $product_image_id)
    {
        $productImage = ProductImage::findOrFail($product_image_id);
        if(File::exists($productImage->image))
            File::delete($productImage->image);
        $productImage->delete();
        return redirect()->back()->with('success','Ảnh sản phẩm đã bị xóa');
    }

}
