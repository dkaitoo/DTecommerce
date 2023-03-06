<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    // bua sau tiep tuc viết hàm CRUD cho product + triển khai giao diện
    protected $fillable = [
        'name',
        'tittle',
        'category_id',
        'seller_id',
        'brand',
        'description',
        'original_price',
        'selling_price',
        'qty',
        'attributes',
        'status',
        'trending',
//        'meta_title',
//        'meta_keywords',
        'other_attribute',
        'average_star',
        'sold'
    ];


    //sp thuoc 1 the loai
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    // 1 product co rat nhiu anh
    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function seller(){
        return $this->belongsTo(Seller::class, 'seller_id', 'id');

    }
}
