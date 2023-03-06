<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'chosen_attribute',
        'process_status',
    ];


    // Item thuộc sản phẩm
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    // Item thuộc giỏ hàng
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
